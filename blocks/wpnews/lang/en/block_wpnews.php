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
 * English language strings for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'WordPress News';
$string['wpnews'] = 'WordPress News';

// Capabilities.
$string['wpnews:addinstance'] = 'Add a new WordPress News block';
$string['wpnews:myaddinstance'] = 'Add a new WordPress News block to My Moodle';
$string['wpnews:viewcontent'] = 'View WordPress News content';

// Block configuration.
$string['blocktitle'] = 'Block title';
$string['blocktitle_help'] = 'Custom title for this block. Leave empty to use the default title.';
$string['defaulttitle'] = 'WordPress News';

// WordPress connection.
$string['wpurl'] = 'WordPress URL';
$string['wpurl_help'] = 'The full URL of your WordPress site (e.g., https://example.com)';
$string['postcount'] = 'Number of posts';
$string['postcount_help'] = 'How many posts to display (1-20)';

// Display options.
$string['displayoptions'] = 'Display options';
$string['layout'] = 'Layout';
$string['layout_help'] = 'Choose between list or grid layout for displaying posts';
$string['layoutlist'] = 'List';
$string['layoutgrid'] = 'Grid';

$string['showimage'] = 'Show featured image';
$string['showimage_help'] = 'Display the featured image for each post';
$string['imagesize'] = 'Image size';
$string['imagesize_help'] = 'Select the size of featured images';
$string['sizethumbnail'] = 'Thumbnail';
$string['sizemedium'] = 'Medium';
$string['sizelarge'] = 'Large';
$string['sizefull'] = 'Full size';

$string['showexcerpt'] = 'Show excerpt';
$string['showexcerpt_help'] = 'Display the post excerpt';
$string['showdate'] = 'Show date';
$string['showdate_help'] = 'Display the publication date';
$string['dateformat'] = 'Date format';
$string['dateformat_help'] = 'PHP date format string (e.g., "F j, Y" for "January 1, 2024")';
$string['showcategories'] = 'Show categories';
$string['showcategories_help'] = 'Display post categories as badges';

// Authentication.
$string['authentication'] = 'Authentication';
$string['username'] = 'Username';
$string['username_help'] = 'WordPress username (optional, for private sites)';
$string['password'] = 'Password';
$string['password_help'] = 'WordPress application password (optional, for private sites)';

// Cache options.
$string['cacheoptions'] = 'Cache options';
$string['cachetime'] = 'Cache duration (minutes)';
$string['cachetime_help'] = 'How long to cache WordPress posts before fetching new data';

// Global settings.
$string['plugininfo'] = 'Plugin information';
$string['plugininfodesc'] = 'This block displays news posts from a WordPress site using the WordPress REST API v2.';
$string['defaultcachetime'] = 'Default cache time';
$string['defaultcachetime_desc'] = 'Default cache duration in minutes for new block instances';
$string['defaultpostcount'] = 'Default post count';
$string['defaultpostcount_desc'] = 'Default number of posts to display for new block instances';
$string['defaultlayout'] = 'Default layout';
$string['defaultlayout_desc'] = 'Default layout style for new block instances';
$string['timeout'] = 'Connection timeout';
$string['timeout_desc'] = 'HTTP request timeout in seconds';
$string['debug'] = 'Enable debugging';
$string['debug_desc'] = 'Log detailed error information for troubleshooting';
$string['cachemanagement'] = 'Cache management';
$string['cachemanagement_desc'] = 'Manage cached WordPress data';
$string['purgecacheinfo'] = 'To clear all cached WordPress posts, use the {$a} page.';

// Messages.
$string['readmore'] = 'Read more';
$string['noposts'] = 'No posts found';
$string['nowpurl'] = 'Please configure the WordPress URL in block settings';
$string['error'] = 'Error loading WordPress posts';

// Validation errors.
$string['invalidurl'] = 'Invalid WordPress URL';
$string['invalidcachetime'] = 'Cache time must be a positive number';
$string['numeric'] = 'Must be a number';
$string['connectionfailed'] = 'Failed to connect to WordPress';

// API errors.
$string['invalidwpurl'] = 'Invalid WordPress URL: {$a}';
$string['curliniterror'] = 'Failed to initialize cURL';
$string['curlerror'] = 'cURL error: {$a}';
$string['authenticationfailed'] = 'Authentication failed. Check your username and password.';
$string['accessforbidden'] = 'Access forbidden. The WordPress site may be private.';
$string['endpointnotfound'] = 'WordPress REST API endpoint not found at {$a}. Make sure the REST API is enabled.';
$string['servererror'] = 'WordPress server error (HTTP {$a})';
$string['httperror'] = 'HTTP error {$a}';
$string['jsonparseerror'] = 'Failed to parse WordPress response: {$a}';
$string['invalidresponse'] = 'Invalid response from WordPress API';

// Privacy.
$string['privacy:metadata'] = 'The WordPress News block only displays data from external WordPress sites and does not store any personal data.';
