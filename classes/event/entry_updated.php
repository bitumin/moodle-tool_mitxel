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
 * Class tool_mitxel\event\entry_updated
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_mitxel\event;

defined('MOODLE_INTERNAL') || die();

use coding_exception;
use core\event\base;
use moodle_exception;
use moodle_url;

/**
 * Class tool_mitxel\event\entry_updated
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class entry_updated extends base {
    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['objecttable'] = 'tool_mitxel';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     * @throws coding_exception
     */
    public static function get_name() {
        return get_string('evententryupdated', 'tool_mitxel');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the entry with id '$this->objectid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return moodle_url
     * @throws moodle_exception
     */
    public function get_url() {
        return new moodle_url('/admin/tool/mitxel/index.php', ['id' => $this->courseid]);
    }

    /**
     * Custom validation.
     *
     * @throws coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (CONTEXT_COURSE !== (int) $this->contextlevel) {
            throw new coding_exception('Context level must be CONTEXT_COURSE.');
        }
    }

    /**
     * This is used when restoring course logs where it is required that we
     * map the objectid to it's new value in the new course.
     *
     * @return string the name of the restore mapping the objectid links to
     */
    public static function get_objectid_mapping() {
        return base::NOT_MAPPED;
    }

    /**
     * This is used when restoring course logs where it is required that we
     * map the information in 'other' to it's new value in the new course.
     *
     * @return bool an array of other values and their corresponding mapping
     */
    public static function get_other_mapping() {
        // Nothing to map.
        return false;
    }
}
