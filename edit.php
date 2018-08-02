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
 * Editing or creating entries
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

$id = optional_param('id', 0, PARAM_INT);

if ($id) {
    // We are going to edit an entry.
    $entry = $DB->get_record('tool_mitxel', ['id' => $id], '*', MUST_EXIST);
    $courseid = $entry->courseid;
    $urlparams = ['id' => $id];
    $title = get_string('newentry', 'tool_mitxel');
} else {
    // We are going to add an entry. Parameter courseid is required.
    $courseid = required_param('courseid', PARAM_INT);
    $entry = (object) ['courseid' => $courseid];
    $urlparams = ['courseid' => $courseid];
    $title = get_string('editentry', 'tool_mitxel');
}

$url = new moodle_url('/admin/tool/mitxel/edit.php', $urlparams);

$PAGE->set_url($url);

require_login($courseid);
$context = context_course::instance($courseid);
require_capability('tool/mitxel:edit', $context);

$PAGE->set_title($title);
$PAGE->set_heading(get_string('pluginname', 'tool_mitxel'));

$form = new tool_mitxel_form();
$form->set_data($entry);

$returnurl = new moodle_url('/admin/tool/mitxel/index.php', ['id' => $courseid]);

if ($form->is_cancelled()) {
    redirect($returnurl);
} else if ($data = $form->get_data()) {
    if ($data->id) {
        // Edit entry. Never modify courseid.
        $DB->update_record('tool_mitxel', (object) [
            'id' => $data->id,
            'name' => $data->name,
            'completed' => $data->completed,
            'timemodified' => time()
        ]);
    } else {
        // Add entry.
        $DB->insert_record('tool_mitxel', (object) [
            'courseid' => $data->courseid,
            'name' => $data->name,
            'completed' => $data->completed,
            'priority' => 0,
            'timecreated' => time(),
            'timemodified' => time()
        ]);
    }
    redirect($returnurl);
}

echo $OUTPUT->header();
echo $OUTPUT->heading($title);

$form->display();

echo $OUTPUT->footer();
