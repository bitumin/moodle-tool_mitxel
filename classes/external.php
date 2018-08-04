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
 * Class tool_mitxel_external
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../../lib/externallib.php');

/**
 * Web services for tool_mitxel
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_mitxel_external extends external_api {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function entries_list_parameters() {
        return new external_function_parameters(
            array('courseid' => new external_value(PARAM_INT, 'Course id', VALUE_REQUIRED))
        );
    }

    /**
     * List of entries in the course
     * @param $courseid
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     * @throws invalid_parameter_exception
     * @throws moodle_exception
     * @throws required_capability_exception
     * @throws restricted_context_exception
     */
    public static function entries_list($courseid) {
        global $PAGE;
        // Parameter validation.
        $params = self::validate_parameters(self::entries_list_parameters(), ['courseid' => $courseid]);
        $courseid = $params['courseid'];

        // From web services we don't call require_login(), but rather validate_context.
        $context = context_course::instance($courseid);
        self::validate_context($context);
        require_capability('tool/mitxel:view', $context);

        $outputpage = new \tool_mitxel\output\entries_list($courseid);
        $renderer = $PAGE->get_renderer('tool_mitxel');

        return $outputpage->export_for_template($renderer);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function entries_list_returns() {
        return new external_single_structure(
            array(
                'courseid' => new external_value(PARAM_INT, 'Course id'),
                'coursename' => new external_value(PARAM_NOTAGS, 'Course name'),
                'contents' => new external_value(PARAM_RAW, 'Contents'),
                'addlink' => new external_value(PARAM_URL, 'Link to add an entry', VALUE_OPTIONAL),
            )
        );
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_entry_parameters() {
        return new external_function_parameters(
            array('id' => new external_value(PARAM_INT, 'Id of an entry', VALUE_REQUIRED))
        );
    }

    /**
     * List of entries in the course
     * @param int $id
     * @return void
     * @throws coding_exception
     * @throws dml_exception
     * @throws invalid_parameter_exception
     * @throws required_capability_exception
     * @throws restricted_context_exception
     */
    public static function delete_entry($id) {
        // Parameter validation.
        $params = self::validate_parameters(self::delete_entry_parameters(), ['id' => $id]);
        $id = $params['id'];

        $entry = tool_mitxel_api::retrieve($id);
        // From web services we don't call require_login(), but rather validate_context.
        $context = context_course::instance($entry->courseid);
        self::validate_context($context);
        require_capability('tool/mitxel:edit', $context);

        tool_mitxel_api::delete($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_entry_returns() {
        return null;
    }
}
