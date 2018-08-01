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
 * Main file
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

$courseid = required_param('id', PARAM_INT);

$url = new moodle_url('/admin/tool/mitxel/index.php', ['id' => $courseid]);

$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('helloworld', 'tool_mitxel'));
$PAGE->set_heading(get_string('pluginname', 'tool_mitxel'));

$course = $DB->get_record_sql('SELECT shortname, fullname FROM {course} WHERE id = ?', [$courseid]);
$coursecount = $DB->count_records('course');

if (!$DB->record_exists('tool_mitxel', ['courseid' => $courseid])) {
    $now = time();
    $DB->insert_record('tool_mitxel', (object) [
        'courseid' => $courseid,
        'name' => $course->fullname,
        'completed' => 0,
        'priority' => 1,
        'timecreated' => $now,
        'timemodified' => $now,
    ]);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('helloworld', 'tool_mitxel'));

echo html_writer::div(get_string('youareviewing', 'tool_mitxel', $courseid));
echo html_writer::div(format_string($course->fullname));
echo html_writer::div(get_string('therearencourses', 'tool_mitxel', $courseid));

// Display table.
$table = new tool_mitxel_table('tool_mitxel', $courseid);
$table->out(0, false);

echo $OUTPUT->footer();
