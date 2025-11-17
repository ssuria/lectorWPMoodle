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
 * Renderer for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_wpnews\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;

/**
 * Renderer class for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {

    /**
     * Render news items using Mustache template.
     *
     * @param news_item $newsitem Renderable news item object
     * @return string HTML output
     */
    public function render_news_item(news_item $newsitem) {
        $data = $newsitem->export_for_template($this);
        return $this->render_from_template('block_wpnews/news_item', $data);
    }

    /**
     * Render method called by the rendering system.
     *
     * @param news_item $newsitem
     * @return string
     */
    protected function render_block_wpnews_output_news_item(news_item $newsitem) {
        return $this->render_news_item($newsitem);
    }

    /**
     * Render a list of news items.
     *
     * @param array $posts Array of post objects
     * @param \stdClass $config Configuration object
     * @return string HTML output
     */
    public function render_news_list($posts, $config) {
        $output = '';

        $layoutclass = ($config->layout === 'grid') ? 'wpnews-grid row' : 'wpnews-list';
        $output .= \html_writer::start_div('block-wpnews-container ' . $layoutclass);

        foreach ($posts as $post) {
            $newsitem = new news_item($post, $config);
            $output .= $this->render_news_item($newsitem);
        }

        $output .= \html_writer::end_div();

        return $output;
    }

    /**
     * Render error message.
     *
     * @param string $message Error message
     * @return string HTML output
     */
    public function render_error($message) {
        return $this->notification($message, 'error');
    }

    /**
     * Render info message.
     *
     * @param string $message Info message
     * @return string HTML output
     */
    public function render_info($message) {
        return $this->notification($message, 'info');
    }

    /**
     * Render warning message.
     *
     * @param string $message Warning message
     * @return string HTML output
     */
    public function render_warning($message) {
        return $this->notification($message, 'warning');
    }
}
