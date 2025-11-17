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
 * Cache handler for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_wpnews\cache;

defined('MOODLE_INTERNAL') || die();

/**
 * Cache handler class.
 *
 * Manages caching of WordPress posts using Moodle Universal Cache (MUC).
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cache_handler {

    /** @var \cache Cache instance */
    private $cache;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->cache = \cache::make('block_wpnews', 'posts');
    }

    /**
     * Get data from cache.
     *
     * @param string $key Cache key
     * @return mixed Cached data or false if not found
     */
    public function get($key) {
        return $this->cache->get($key);
    }

    /**
     * Set data in cache.
     *
     * @param string $key Cache key
     * @param mixed $data Data to cache
     * @param int $ttl Time to live in seconds (optional, uses cache definition default if not specified)
     * @return bool True on success
     */
    public function set($key, $data, $ttl = null) {
        if ($ttl !== null) {
            // Store with timestamp for TTL checking.
            $cachedata = [
                'data' => $data,
                'timestamp' => time(),
                'ttl' => $ttl,
            ];
            return $this->cache->set($key, $cachedata);
        } else {
            return $this->cache->set($key, $data);
        }
    }

    /**
     * Get data from cache with TTL checking.
     *
     * @param string $key Cache key
     * @return mixed Cached data or false if not found or expired
     */
    public function get_with_ttl($key) {
        $cachedata = $this->cache->get($key);

        if ($cachedata === false) {
            return false;
        }

        // Check if this is TTL-aware cache data.
        if (is_array($cachedata) && isset($cachedata['timestamp']) && isset($cachedata['ttl'])) {
            $age = time() - $cachedata['timestamp'];

            if ($age > $cachedata['ttl']) {
                // Cache expired, delete it.
                $this->delete($key);
                return false;
            }

            return $cachedata['data'];
        }

        // Not TTL-aware, return as is.
        return $cachedata;
    }

    /**
     * Delete data from cache.
     *
     * @param string $key Cache key
     * @return bool True on success
     */
    public function delete($key) {
        return $this->cache->delete($key);
    }

    /**
     * Purge all cache for this block.
     *
     * @return bool True on success
     */
    public function purge_all() {
        return $this->cache->purge();
    }

    /**
     * Check if cache contains key.
     *
     * @param string $key Cache key
     * @return bool True if key exists
     */
    public function has($key) {
        return $this->cache->has($key);
    }

    /**
     * Generate cache key from parameters.
     *
     * @param string $prefix Key prefix
     * @param array $params Parameters to include in key
     * @return string Cache key
     */
    public static function generate_key($prefix, $params = []) {
        $keyparts = [$prefix];

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $value = md5(serialize($value));
            }
            $keyparts[] = $key . '_' . $value;
        }

        return implode('_', $keyparts);
    }

    /**
     * Get cache statistics for a specific key.
     *
     * @param string $key Cache key
     * @return array|null Statistics or null if not found
     */
    public function get_stats($key) {
        $cachedata = $this->cache->get($key);

        if ($cachedata === false) {
            return null;
        }

        if (is_array($cachedata) && isset($cachedata['timestamp']) && isset($cachedata['ttl'])) {
            $age = time() - $cachedata['timestamp'];
            $remaining = max(0, $cachedata['ttl'] - $age);

            return [
                'age' => $age,
                'ttl' => $cachedata['ttl'],
                'remaining' => $remaining,
                'expired' => $age > $cachedata['ttl'],
            ];
        }

        return [
            'age' => null,
            'ttl' => null,
            'remaining' => null,
            'expired' => false,
        ];
    }
}
