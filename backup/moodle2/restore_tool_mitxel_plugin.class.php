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

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../../../backup/moodle2/restore_tool_plugin.class.php');

class restore_tool_mitxel_plugin extends restore_tool_plugin {
    protected $mitxels;

    /**
     * @return array
     */
    protected function define_course_plugin_structure() {
        $paths = array();
        $paths[] = new restore_path_element('mitxel', '/course/mitxel');

        return $paths;
    }

    /**
     * @param array|stdClass|object $data
     * @throws dml_exception
     */
    public function process_mitxel($data) {
        global $DB;

        $data = (object) $data;

        // Store the old id.
        $oldid = $data->id;

        // Change the values before we insert it.
        $data->courseid = $this->task->get_courseid();
        $data->timecreated = time();
        $data->timemodified = $data->timecreated;

        // Now we can insert the new record.
        $data->id = $DB->insert_record('tool_mitxel', $data);

        // Add the array of tools we need to process later.
        $this->mitxels[$data->id] = $data;

        // Set up the mapping.
        $this->set_mapping('mitxel', $oldid, $data->id);
    }
}
