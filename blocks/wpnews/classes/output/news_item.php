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
 * News item renderable for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_wpnews\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * News item renderable class.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class news_item implements renderable, templatable {

    /** @var stdClass The post object */
    protected $post;

    /** @var stdClass Configuration object */
    protected $config;

    /**
     * Constructor.
     *
     * @param stdClass $post Post object
     * @param stdClass $config Configuration object
     */
    public function __construct(stdClass $post, stdClass $config) {
        $this->post = $post;
        $this->config = $config;
    }

    /**
     * Export data for template.
     *
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        $data = new stdClass();

        // Basic properties.
        $data->title = format_string($this->post->title);
        $data->link = $this->post->link;
        $data->excerpt = strip_tags($this->post->excerpt);

        // Layout class.
        $data->layoutclass = ($this->config->layout === 'grid') ? 'col-md-6 col-lg-4 mb-3' : 'mb-3';

        // Date.
        if ($this->config->showdate && !empty($this->post->date)) {
            $timestamp = strtotime($this->post->date);
            $data->date = userdate($timestamp, $this->config->dateformat);
            $data->showdate = true;
        } else {
            $data->showdate = false;
        }

        // Image.
        if ($this->config->showimage) {
            $data->imageurl = $this->get_image_url();
            $data->showimage = !empty($data->imageurl);
        } else {
            $data->showimage = false;
        }

        // Excerpt.
        $data->showexcerpt = $this->config->showexcerpt && !empty($data->excerpt);

        // Categories.
        if ($this->config->showcategories && !empty($this->post->categories)) {
            $data->categories = $this->post->categories;
            $data->showcategories = true;
        } else {
            $data->showcategories = false;
        }

        // Read more text.
        $data->readmore = get_string('readmore', 'block_wpnews');

        return $data;
    }

    /**
     * Get image URL for configured size.
     *
     * @return string|null
     */
    protected function get_image_url() {
        if (empty($this->post->featured_image_url)) {
            return null;
        }

        $size = $this->config->imagesize;

        // Try to get specific size from embedded data.
        if (!empty($this->post->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->$size->source_url)) {
            return $this->post->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->$size->source_url;
        }

        // Fallback to main image URL.
        return $this->post->featured_image_url;
    }
}
