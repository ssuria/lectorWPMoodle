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
 * Main block class for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/wpnews/classes/api/wordpress_client.php');
require_once($CFG->dirroot . '/blocks/wpnews/classes/cache/cache_handler.php');

/**
 * WordPress News block class.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_wpnews extends block_base {

    /**
     * Initialize the block.
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_wpnews');
    }

    /**
     * Set the applicable formats for this block.
     *
     * @return array
     */
    public function applicable_formats() {
        return [
            'site-index' => true,
            'course-view' => true,
            'my' => true,
            'all' => false,
        ];
    }

    /**
     * Allow multiple instances of this block.
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Has global configuration.
     *
     * @return bool
     */
    public function has_config() {
        return true;
    }

    /**
     * Allow per-instance configuration.
     *
     * @return bool
     */
    public function instance_allow_config() {
        return true;
    }

    /**
     * Specialize - set custom title if configured.
     */
    public function specialization() {
        if (isset($this->config->title) && !empty($this->config->title)) {
            $this->title = format_string($this->config->title);
        } else {
            $this->title = get_string('defaulttitle', 'block_wpnews');
        }
    }

    /**
     * Get the block content.
     *
     * @return stdClass
     */
    public function get_content() {
        global $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';

        // Check if WordPress URL is configured.
        if (empty($this->config->wpurl)) {
            $this->content->text = $OUTPUT->notification(
                get_string('nowpurl', 'block_wpnews'),
                'warning'
            );
            return $this->content;
        }

        // Check capability.
        $context = context_block::instance($this->instance->id);
        if (!has_capability('block/wpnews:viewcontent', $context)) {
            return $this->content;
        }

        try {
            // Get configuration with defaults.
            $config = $this->get_config_with_defaults();

            // Try to get posts from cache first.
            $cachehandler = new \block_wpnews\cache\cache_handler();
            $cachekey = 'wp_posts_' . $this->instance->id;
            $posts = $cachehandler->get($cachekey);

            if ($posts === false) {
                // Not in cache, fetch from WordPress.
                $client = new \block_wpnews\api\wordpress_client();

                $params = [
                    'per_page' => $config->postcount,
                    '_embed' => 'true', // Include embedded data like featured images.
                ];

                $auth = null;
                if (!empty($config->username) && !empty($config->password)) {
                    $auth = [
                        'username' => $config->username,
                        'password' => $config->password,
                    ];
                }

                $posts = $client->fetch_posts($config->wpurl, $params, $auth);

                // Store in cache.
                $cachehandler->set($cachekey, $posts, $config->cachetime * 60);
            }

            // Render the posts.
            if (!empty($posts)) {
                $this->content->text = $this->render_posts($posts, $config);
            } else {
                $this->content->text = $OUTPUT->notification(
                    get_string('noposts', 'block_wpnews'),
                    'info'
                );
            }

        } catch (Exception $e) {
            $this->content->text = $OUTPUT->notification(
                get_string('error', 'block_wpnews') . ': ' . $e->getMessage(),
                'error'
            );
        }

        return $this->content;
    }

    /**
     * Get configuration with default values.
     *
     * @return stdClass
     */
    private function get_config_with_defaults() {
        $config = new stdClass();

        $config->wpurl = $this->config->wpurl ?? '';
        $config->postcount = $this->config->postcount ?? 5;
        $config->showimage = $this->config->showimage ?? 1;
        $config->showexcerpt = $this->config->showexcerpt ?? 1;
        $config->showdate = $this->config->showdate ?? 1;
        $config->showcategories = $this->config->showcategories ?? 1;
        $config->imagesize = $this->config->imagesize ?? 'medium';
        $config->dateformat = $this->config->dateformat ?? 'F j, Y';
        $config->layout = $this->config->layout ?? 'list';
        $config->cachetime = $this->config->cachetime ?? 30;
        $config->username = $this->config->username ?? '';
        $config->password = $this->config->password ?? '';

        return $config;
    }

    /**
     * Render posts HTML using Mustache templates.
     *
     * @param array $posts
     * @param stdClass $config
     * @return string
     */
    private function render_posts($posts, $config) {
        global $OUTPUT, $PAGE;

        // Add RemUI-specific CSS if RemUI theme is active.
        if ($PAGE->theme->name === 'remui') {
            $PAGE->requires->css('/blocks/wpnews/styles_remui.css');
        }

        // Use renderer for better template support.
        $renderer = $PAGE->get_renderer('block_wpnews');

        $newsitems = [];
        foreach ($posts as $post) {
            $newsitem = new \block_wpnews\output\news_item($post, $config);
            $newsitems[] = $renderer->render($newsitem);
        }

        // Render container.
        $data = [
            'isgrid' => ($config->layout === 'grid'),
            'newsitems' => $newsitems,
        ];

        return $OUTPUT->render_from_template('block_wpnews/news_container', $data);
    }

    /**
     * Render a single post.
     *
     * @param stdClass $post
     * @param stdClass $config
     * @return string
     */
    private function render_single_post($post, $config) {
        $output = '';

        $output .= html_writer::start_div('wpnews-item card mb-3');

        // Featured image.
        if ($config->showimage && !empty($post->featured_image_url)) {
            $imgurl = $this->get_image_url($post, $config->imagesize);
            if ($imgurl) {
                $output .= html_writer::start_div('wpnews-image');
                $output .= html_writer::img(
                    $imgurl,
                    $post->title,
                    ['class' => 'img-fluid', 'loading' => 'lazy']
                );
                $output .= html_writer::end_div();
            }
        }

        $output .= html_writer::start_div('card-body');

        // Title.
        $title = html_writer::link(
            $post->link,
            format_string($post->title),
            ['target' => '_blank', 'rel' => 'noopener noreferrer', 'class' => 'wpnews-title']
        );
        $output .= html_writer::tag('h5', $title, ['class' => 'card-title']);

        // Date.
        if ($config->showdate && !empty($post->date)) {
            $timestamp = strtotime($post->date);
            $datestr = userdate($timestamp, $config->dateformat);
            $output .= html_writer::tag(
                'small',
                $datestr,
                ['class' => 'text-muted wpnews-date d-block mb-2']
            );
        }

        // Categories.
        if ($config->showcategories && !empty($post->categories)) {
            $output .= $this->render_categories($post->categories);
        }

        // Excerpt.
        if ($config->showexcerpt && !empty($post->excerpt)) {
            $excerpt = strip_tags($post->excerpt);
            $output .= html_writer::tag('p', $excerpt, ['class' => 'card-text wpnews-excerpt']);
        }

        // Read more link.
        $readmore = html_writer::link(
            $post->link,
            get_string('readmore', 'block_wpnews'),
            ['target' => '_blank', 'rel' => 'noopener noreferrer', 'class' => 'btn btn-sm btn-primary']
        );
        $output .= $readmore;

        $output .= html_writer::end_div(); // card-body.
        $output .= html_writer::end_div(); // wpnews-item.

        return $output;
    }

    /**
     * Get image URL for the specified size.
     *
     * @param stdClass $post
     * @param string $size
     * @return string|null
     */
    private function get_image_url($post, $size) {
        if (empty($post->featured_image_url)) {
            return null;
        }

        // If we have embedded media data.
        if (!empty($post->_embedded['wp:featuredmedia'][0]['media_details']['sizes'][$size]['source_url'])) {
            return $post->_embedded['wp:featuredmedia'][0]['media_details']['sizes'][$size]['source_url'];
        }

        // Fallback to the main featured image URL.
        return $post->featured_image_url;
    }

    /**
     * Render categories as badges.
     *
     * @param array $categories
     * @return string
     */
    private function render_categories($categories) {
        $output = html_writer::start_div('wpnews-categories mb-2');

        foreach ($categories as $category) {
            $output .= html_writer::tag(
                'span',
                format_string($category->name),
                ['class' => 'badge badge-secondary mr-1']
            );
        }

        $output .= html_writer::end_div();

        return $output;
    }
}
