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
 * Class tool_mitxel_table
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../../lib/tablelib.php');

/**
 * Class tool_mitxel_table for displaying tool_mitxel table
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_mitxel_table extends table_sql {
    /** @var context_course */
    protected $context;

    /**
     * Sets up the table_mitxel parameters.
     *
     * @param string $uniqueid unique id of form.
     * @param int $courseid
     * @throws coding_exception
     */
    public function __construct($uniqueid, $courseid) {
        global $PAGE;
        parent::__construct($uniqueid);

        $this->define_columns(['name', 'completed', 'priority', 'timecreated', 'timemodified']);
        $this->define_headers([
            get_string('name', 'tool_mitxel'),
            get_string('completed', 'tool_mitxel'),
            get_string('priority', 'tool_mitxel'),
            get_string('timecreated', 'tool_mitxel'),
            get_string('timemodified', 'tool_mitxel'),
        ]);
        $this->pageable(true);
        $this->collapsible(false);
        $this->sortable(false);
        $this->is_downloadable(false);
        $this->define_baseurl($PAGE->url);
        $this->context = context_course::instance($courseid);
        $this->set_sql('name, completed, priority, timecreated, timemodified', '{tool_mitxel}', 'courseid = ?', [$courseid]);
    }

    /**
     * Displays column completed
     *
     * @param stdClass $row
     * @return string
     * @throws coding_exception
     */
    protected function col_completed($row) {
        return $row->completed ? get_string('yes') : get_string('no');
    }

    /**
     * Displays column priority
     *
     * @param stdClass $row
     * @return string
     * @throws coding_exception
     */
    protected function col_priority($row) {
        return $row->priority ? get_string('yes') : get_string('no');
    }

    /**
     * Displays column name
     *
     * @param stdClass $row
     * @return string
     */
    protected function col_name($row) {
        return format_string($row->name, true, ['context' => $this->context]);
    }

    /**
     * Displays column timecreated
     *
     * @param stdClass $row
     * @return string
     * @throws coding_exception
     */
    protected function col_timecreated($row) {
        return userdate($row->timecreated, get_string('strftimedatetime'));
    }

    /**
     * Displays column timemodified
     *
     * @param stdClass $row
     * @return string
     * @throws coding_exception
     */
    protected function col_timemodified($row) {
        return userdate($row->timemodified, get_string('strftimedatetime'));
    }
}
