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

require_login($courseid);
$context = context_course::instance($courseid);
require_capability('tool/mitxel:view', $context);

$url = new moodle_url('/admin/tool/mitxel/index.php', ['id' => $courseid]);

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('helloworld', 'tool_mitxel'));
$PAGE->set_heading(get_string('pluginname', 'tool_mitxel'));

$course = $DB->get_record_sql('SELECT shortname, fullname FROM {course} WHERE id = ?', [$courseid]);
$coursecount = $DB->count_records('course');

if (!$DB->record_exists('tool_mitxel', ['courseid' => $courseid])) {
    tool_mitxel_api::insert((object) [
        'courseid' => $courseid,
        'name' => $course->fullname,
        'completed' => 0,
        'priority' => 1,
    ]);
}

// Deleting an entry if specified.
if ($deleteid = optional_param('delete', null, PARAM_INT)) {
    require_sesskey();
    $record = tool_mitxel_api::retrieve($deleteid, $courseid);
    require_capability('tool/mitxel:edit', $PAGE->context);

    tool_mitxel_api::delete($record->id);

    redirect(new moodle_url('/admin/tool/mitxel/index.php', ['id' => $courseid]));
}

$outputpage = new \tool_mitxel\output\entries_list($courseid);
/** @var tool_mitxel_renderer $output */
$output = $PAGE->get_renderer('tool_mitxel');
echo $output->header();
echo $output->render($outputpage);
echo $output->footer();
