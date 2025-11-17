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
 * Global settings for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // Information section.
    $settings->add(new admin_setting_heading(
        'block_wpnews/info',
        get_string('plugininfo', 'block_wpnews'),
        get_string('plugininfodesc', 'block_wpnews')
    ));

    // Default cache time.
    $settings->add(new admin_setting_configtext(
        'block_wpnews/defaultcachetime',
        get_string('defaultcachetime', 'block_wpnews'),
        get_string('defaultcachetime_desc', 'block_wpnews'),
        30,
        PARAM_INT
    ));

    // Default number of posts.
    $postoptions = [];
    for ($i = 1; $i <= 20; $i++) {
        $postoptions[$i] = $i;
    }
    $settings->add(new admin_setting_configselect(
        'block_wpnews/defaultpostcount',
        get_string('defaultpostcount', 'block_wpnews'),
        get_string('defaultpostcount_desc', 'block_wpnews'),
        5,
        $postoptions
    ));

    // Default layout.
    $layoutoptions = [
        'list' => get_string('layoutlist', 'block_wpnews'),
        'grid' => get_string('layoutgrid', 'block_wpnews'),
    ];
    $settings->add(new admin_setting_configselect(
        'block_wpnews/defaultlayout',
        get_string('defaultlayout', 'block_wpnews'),
        get_string('defaultlayout_desc', 'block_wpnews'),
        'list',
        $layoutoptions
    ));

    // Connection timeout.
    $settings->add(new admin_setting_configtext(
        'block_wpnews/timeout',
        get_string('timeout', 'block_wpnews'),
        get_string('timeout_desc', 'block_wpnews'),
        10,
        PARAM_INT
    ));

    // Enable debugging.
    $settings->add(new admin_setting_configcheckbox(
        'block_wpnews/debug',
        get_string('debug', 'block_wpnews'),
        get_string('debug_desc', 'block_wpnews'),
        0
    ));

    // Cache management section.
    $settings->add(new admin_setting_heading(
        'block_wpnews/cacheheading',
        get_string('cachemanagement', 'block_wpnews'),
        get_string('cachemanagement_desc', 'block_wpnews')
    ));

    // Link to purge all caches.
    $url = new moodle_url('/admin/purgecaches.php', ['confirm' => 1, 'sesskey' => sesskey()]);
    $link = html_writer::link($url, get_string('purgecaches', 'admin'));
    $settings->add(new admin_setting_heading(
        'block_wpnews/purgecachelink',
        '',
        get_string('purgecacheinfo', 'block_wpnews', $link)
    ));
}
