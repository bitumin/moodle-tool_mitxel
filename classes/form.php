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
 * Class tool_mitxel_form
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../../lib/formslib.php');

/**
 * Class tool_mitxel_form for displaying an editing form
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_mitxel_form extends moodleform {
    /**
     * Form definition
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $namestr = get_string('name', 'tool_mitxel');
        $mform->addElement('text', 'name', $namestr);
        $mform->setType('name', PARAM_NOTAGS);

        $completedstr = get_string('completed', 'tool_mitxel');
        $mform->addElement('advcheckbox', 'completed', $completedstr);

        $descriptionstr = get_string('description', 'tool_mitxel');
        $editoroptions = tool_mitxel_api::editor_options();
        $mform->addElement('editor', 'description_editor', $descriptionstr, null, $editoroptions);

        $this->add_action_buttons();
    }

    /**
     * Form validation
     *
     * @param array $data
     * @param array $files
     * @return array
     * @throws coding_exception
     * @throws dml_exception
     */
    public function validation($data, $files) {
        global $DB;

        $errors = parent::validation($data, $files);

        // Check that name is unique for the course.
        $select = 'name = :name AND id <> :id AND courseid = :courseid';
        $recordexists = $DB->record_exists_select('tool_mitxel', $select, [
            'name' => $data['name'],
            'id' => $data['id'],
            'courseid' => $data['courseid']
        ]);
        if ($recordexists) {
            $errors['name'] = get_string('errornameexists', 'tool_mitxel');
        }

        return $errors;
    }
}
