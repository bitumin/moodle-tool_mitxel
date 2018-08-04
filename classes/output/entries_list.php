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
 * Class tool_mitxel\output\entries_list
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_mitxel\output;

defined('MOODLE_INTERNAL') || die();

use coding_exception;
use dml_exception;
use moodle_exception;
use renderer_base;
use moodle_url;
use tool_mitxel_table;
use context_course;

/**
 * Class tool_mitxel\output\entries_list
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class entries_list implements \templatable, \renderable {
    /** @var int */
    protected $courseid;

    /**
     * entries_list constructor.
     * @param int $courseid
     */
    public function __construct($courseid) {
        $this->courseid = $courseid;
    }

    /**
     * Implementation of exporter from templatable interface
     *
     * @param renderer_base $output
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public function export_for_template(renderer_base $output) {
        $course = get_course($this->courseid);
        $context = context_course::instance($this->courseid);
        $data = [
            'courseid' => $this->courseid,
            'coursename' => format_string($course->fullname, true, ['context' => $context])
        ];

        // Display table.
        ob_start();
        $table = new tool_mitxel_table('tool_mitxel', $this->courseid);
        $table->out(20, false);
        $data['contents'] = ob_get_clean();

        // Link to add new entry.
        if (has_capability('tool/mitxel:edit', $context)) {
            $url = new moodle_url('/admin/tool/mitxel/edit.php', ['courseid' => $this->courseid]);
            // Link will be escaped inside template so no need to escape it now.
            $data['addlink'] = $url->out(false);
        }

        return $data;
    }
}
