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
 * Block instance configuration form for WordPress News block.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Block instance configuration form class.
 *
 * @package    block_wpnews
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_wpnews_edit_form extends block_edit_form {

    /**
     * Extend the block configuration form.
     *
     * @param MoodleQuickForm $mform
     */
    protected function specific_definition($mform) {

        // Section header.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Block title.
        $mform->addElement('text', 'config_title', get_string('blocktitle', 'block_wpnews'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->addHelpButton('config_title', 'blocktitle', 'block_wpnews');

        // WordPress URL (required).
        $mform->addElement('text', 'config_wpurl', get_string('wpurl', 'block_wpnews'), ['size' => 60]);
        $mform->setType('config_wpurl', PARAM_URL);
        $mform->addRule('config_wpurl', get_string('required'), 'required', null, 'client');
        $mform->addHelpButton('config_wpurl', 'wpurl', 'block_wpnews');

        // Number of posts to display.
        $postoptions = [];
        for ($i = 1; $i <= 20; $i++) {
            $postoptions[$i] = $i;
        }
        $mform->addElement('select', 'config_postcount', get_string('postcount', 'block_wpnews'), $postoptions);
        $mform->setDefault('config_postcount', 5);
        $mform->addHelpButton('config_postcount', 'postcount', 'block_wpnews');

        // Display options section.
        $mform->addElement('header', 'displayoptions', get_string('displayoptions', 'block_wpnews'));

        // Layout (list or grid).
        $layoutoptions = [
            'list' => get_string('layoutlist', 'block_wpnews'),
            'grid' => get_string('layoutgrid', 'block_wpnews'),
        ];
        $mform->addElement('select', 'config_layout', get_string('layout', 'block_wpnews'), $layoutoptions);
        $mform->setDefault('config_layout', 'list');
        $mform->addHelpButton('config_layout', 'layout', 'block_wpnews');

        // Show featured image.
        $mform->addElement('advcheckbox', 'config_showimage', get_string('showimage', 'block_wpnews'));
        $mform->setDefault('config_showimage', 1);
        $mform->addHelpButton('config_showimage', 'showimage', 'block_wpnews');

        // Image size.
        $sizeoptions = [
            'thumbnail' => get_string('sizethumbnail', 'block_wpnews'),
            'medium' => get_string('sizemedium', 'block_wpnews'),
            'large' => get_string('sizelarge', 'block_wpnews'),
            'full' => get_string('sizefull', 'block_wpnews'),
        ];
        $mform->addElement('select', 'config_imagesize', get_string('imagesize', 'block_wpnews'), $sizeoptions);
        $mform->setDefault('config_imagesize', 'medium');
        $mform->disabledIf('config_imagesize', 'config_showimage');
        $mform->addHelpButton('config_imagesize', 'imagesize', 'block_wpnews');

        // Show excerpt.
        $mform->addElement('advcheckbox', 'config_showexcerpt', get_string('showexcerpt', 'block_wpnews'));
        $mform->setDefault('config_showexcerpt', 1);
        $mform->addHelpButton('config_showexcerpt', 'showexcerpt', 'block_wpnews');

        // Show date.
        $mform->addElement('advcheckbox', 'config_showdate', get_string('showdate', 'block_wpnews'));
        $mform->setDefault('config_showdate', 1);
        $mform->addHelpButton('config_showdate', 'showdate', 'block_wpnews');

        // Date format.
        $mform->addElement('text', 'config_dateformat', get_string('dateformat', 'block_wpnews'));
        $mform->setType('config_dateformat', PARAM_TEXT);
        $mform->setDefault('config_dateformat', 'F j, Y');
        $mform->disabledIf('config_dateformat', 'config_showdate');
        $mform->addHelpButton('config_dateformat', 'dateformat', 'block_wpnews');

        // Show categories.
        $mform->addElement('advcheckbox', 'config_showcategories', get_string('showcategories', 'block_wpnews'));
        $mform->setDefault('config_showcategories', 1);
        $mform->addHelpButton('config_showcategories', 'showcategories', 'block_wpnews');

        // Authentication section.
        $mform->addElement('header', 'authoptions', get_string('authentication', 'block_wpnews'));
        $mform->setExpanded('authoptions', false);

        // Username.
        $mform->addElement('text', 'config_username', get_string('username', 'block_wpnews'));
        $mform->setType('config_username', PARAM_TEXT);
        $mform->addHelpButton('config_username', 'username', 'block_wpnews');

        // Password.
        $mform->addElement('passwordunmask', 'config_password', get_string('password', 'block_wpnews'));
        $mform->setType('config_password', PARAM_TEXT);
        $mform->addHelpButton('config_password', 'password', 'block_wpnews');

        // Cache section.
        $mform->addElement('header', 'cacheoptions', get_string('cacheoptions', 'block_wpnews'));
        $mform->setExpanded('cacheoptions', false);

        // Cache time (in minutes).
        $mform->addElement('text', 'config_cachetime', get_string('cachetime', 'block_wpnews'));
        $mform->setType('config_cachetime', PARAM_INT);
        $mform->setDefault('config_cachetime', 30);
        $mform->addRule('config_cachetime', get_string('required'), 'required', null, 'client');
        $mform->addRule('config_cachetime', get_string('numeric', 'block_wpnews'), 'numeric', null, 'client');
        $mform->addHelpButton('config_cachetime', 'cachetime', 'block_wpnews');
    }

    /**
     * Validate the configuration form.
     *
     * @param array $data
     * @param array $files
     * @return array Validation errors
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // Validate WordPress URL.
        if (!empty($data['config_wpurl'])) {
            $url = trim($data['config_wpurl']);

            // Check URL format.
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $errors['config_wpurl'] = get_string('invalidurl', 'block_wpnews');
            }

            // Try to validate connection if URL is valid.
            if (!isset($errors['config_wpurl'])) {
                try {
                    require_once(__DIR__ . '/classes/api/wordpress_client.php');
                    $client = new \block_wpnews\api\wordpress_client();

                    $auth = null;
                    if (!empty($data['config_username']) && !empty($data['config_password'])) {
                        $auth = [
                            'username' => $data['config_username'],
                            'password' => $data['config_password'],
                        ];
                    }

                    // This will throw exception if connection fails.
                    $client->validate_connection($url, $auth);

                } catch (Exception $e) {
                    $errors['config_wpurl'] = get_string('connectionfailed', 'block_wpnews') . ': ' . $e->getMessage();
                }
            }
        }

        // Validate cache time.
        if (isset($data['config_cachetime'])) {
            if (!is_numeric($data['config_cachetime']) || $data['config_cachetime'] < 1) {
                $errors['config_cachetime'] = get_string('invalidcachetime', 'block_wpnews');
            }
        }

        return $errors;
    }
}
