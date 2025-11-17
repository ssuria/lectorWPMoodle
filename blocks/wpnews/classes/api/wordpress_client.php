<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * WordPress REST API client for fetching posts.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_wpnews\api;

defined('MOODLE_INTERNAL') || die();

/**
 * WordPress API client class.
 *
 * Handles communication with WordPress REST API v2.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class wordpress_client {

    /** @var int Default timeout in seconds */
    const DEFAULT_TIMEOUT = 10;

    /** @var int Connect timeout in seconds */
    const CONNECT_TIMEOUT = 5;

    /** @var string WordPress REST API endpoint path */
    const API_ENDPOINT = '/wp-json/wp/v2/posts';

    /**
     * Fetch posts from WordPress REST API.
     *
     * @param string $wpurl WordPress site URL
     * @param array $params Query parameters
     * @param array|null $auth Authentication credentials ['username' => '', 'password' => '']
     * @return array Array of post objects
     * @throws \moodle_exception
     */
    public function fetch_posts($wpurl, $params = [], $auth = null) {
        // Validate and sanitize URL.
        $wpurl = $this->validate_url($wpurl);

        // Build API endpoint URL.
        $apiurl = rtrim($wpurl, '/') . self::API_ENDPOINT;

        // Add query parameters.
        if (!empty($params)) {
            $apiurl .= '?' . http_build_query($params);
        }

        // Make HTTP request.
        $response = $this->make_request($apiurl, $auth);

        // Parse and return posts.
        return $this->parse_response($response);
    }

    /**
     * Validate WordPress connection.
     *
     * @param string $wpurl WordPress site URL
     * @param array|null $auth Authentication credentials
     * @return bool True if connection is valid
     * @throws \moodle_exception
     */
    public function validate_connection($wpurl, $auth = null) {
        try {
            $wpurl = $this->validate_url($wpurl);
            $apiurl = rtrim($wpurl, '/') . self::API_ENDPOINT;

            // Try to fetch just one post to test connection.
            $testurl = $apiurl . '?per_page=1';
            $this->make_request($testurl, $auth);

            return true;
        } catch (\moodle_exception $e) {
            throw $e;
        }
    }

    /**
     * Validate and sanitize URL.
     *
     * @param string $url URL to validate
     * @return string Validated URL
     * @throws \moodle_exception
     */
    private function validate_url($url) {
        // Remove whitespace.
        $url = trim($url);

        // Ensure https for security.
        if (strpos($url, 'http://') === 0) {
            $url = str_replace('http://', 'https://', $url);
        }

        // Add https if no protocol specified.
        if (strpos($url, 'https://') !== 0 && strpos($url, 'http://') !== 0) {
            $url = 'https://' . $url;
        }

        // Validate URL format.
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \moodle_exception('invalidwpurl', 'block_wpnews', '', $url);
        }

        return $url;
    }

    /**
     * Make HTTP request using cURL.
     *
     * @param string $url URL to request
     * @param array|null $auth Authentication credentials
     * @return string Response body
     * @throws \moodle_exception
     */
    private function make_request($url, $auth = null) {
        // Initialize cURL.
        $ch = curl_init();

        if ($ch === false) {
            throw new \moodle_exception('curliniterror', 'block_wpnews');
        }

        // Set cURL options.
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_TIMEOUT => self::DEFAULT_TIMEOUT,
            CURLOPT_CONNECTTIMEOUT => self::CONNECT_TIMEOUT,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_USERAGENT => 'Moodle-WordPress-News-Block/1.0',
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
            ],
        ];

        // Add authentication if provided.
        if (!empty($auth) && !empty($auth['username']) && !empty($auth['password'])) {
            $options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
            $options[CURLOPT_USERPWD] = $auth['username'] . ':' . $auth['password'];
        }

        curl_setopt_array($ch, $options);

        // Execute request.
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $errno = curl_errno($ch);

        curl_close($ch);

        // Handle errors.
        if ($errno !== 0) {
            throw new \moodle_exception('curlerror', 'block_wpnews', '', $error);
        }

        // Check HTTP status codes.
        $this->handle_http_status($httpcode, $url);

        return $response;
    }

    /**
     * Handle HTTP status codes.
     *
     * @param int $httpcode HTTP status code
     * @param string $url Request URL
     * @throws \moodle_exception
     */
    private function handle_http_status($httpcode, $url) {
        switch ($httpcode) {
            case 200:
            case 201:
                // Success.
                return;

            case 401:
                throw new \moodle_exception('authenticationfailed', 'block_wpnews');

            case 403:
                throw new \moodle_exception('accessforbidden', 'block_wpnews');

            case 404:
                throw new \moodle_exception('endpointnotfound', 'block_wpnews', '', $url);

            case 500:
            case 502:
            case 503:
            case 504:
                throw new \moodle_exception('servererror', 'block_wpnews', '', $httpcode);

            default:
                if ($httpcode >= 400) {
                    throw new \moodle_exception('httperror', 'block_wpnews', '', $httpcode);
                }
        }
    }

    /**
     * Parse JSON response from WordPress API.
     *
     * @param string $response JSON response body
     * @return array Array of post objects
     * @throws \moodle_exception
     */
    private function parse_response($response) {
        $data = json_decode($response);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \moodle_exception('jsonparseerror', 'block_wpnews', '', json_last_error_msg());
        }

        if (!is_array($data)) {
            throw new \moodle_exception('invalidresponse', 'block_wpnews');
        }

        // Process each post.
        $posts = [];
        foreach ($data as $post) {
            $posts[] = $this->process_post($post);
        }

        return $posts;
    }

    /**
     * Process a single post object.
     *
     * @param stdClass $post Raw post object from API
     * @return stdClass Processed post object
     */
    private function process_post($post) {
        $processed = new \stdClass();

        // Basic fields.
        $processed->id = $post->id ?? 0;
        $processed->title = $post->title->rendered ?? '';
        $processed->link = $post->link ?? '';
        $processed->date = $post->date ?? '';
        $processed->excerpt = $post->excerpt->rendered ?? '';

        // Featured image.
        $processed->featured_image_url = null;
        if (!empty($post->_embedded->{'wp:featuredmedia'}[0]->source_url)) {
            $processed->featured_image_url = $post->_embedded->{'wp:featuredmedia'}[0]->source_url;
        }

        // Store embedded data for different image sizes.
        if (!empty($post->_embedded)) {
            $processed->_embedded = $post->_embedded;
        }

        // Categories.
        $processed->categories = [];
        if (!empty($post->_embedded->{'wp:term'}[0])) {
            foreach ($post->_embedded->{'wp:term'}[0] as $category) {
                $cat = new \stdClass();
                $cat->id = $category->id ?? 0;
                $cat->name = $category->name ?? '';
                $cat->slug = $category->slug ?? '';
                $processed->categories[] = $cat;
            }
        }

        return $processed;
    }

    /**
     * Get featured image URL for specific size.
     *
     * @param stdClass $post Post object
     * @param string $size Image size (thumbnail, medium, large, full)
     * @return string|null Image URL or null
     */
    public function get_featured_image($post, $size = 'medium') {
        if (empty($post->_embedded->{'wp:featuredmedia'}[0])) {
            return null;
        }

        $media = $post->_embedded->{'wp:featuredmedia'}[0];

        // Try to get specific size.
        if (!empty($media->media_details->sizes->$size->source_url)) {
            return $media->media_details->sizes->$size->source_url;
        }

        // Fallback to full size.
        return $media->source_url ?? null;
    }
}
