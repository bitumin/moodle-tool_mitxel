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
 * Web services for tool_mitxel
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// We defined the web service functions to install.
$functions = array(
    'tool_mitxel_delete_entry' => array(
        'classname' => 'tool_mitxel_external',
        'methodname' => 'delete_entry',
        'description' => 'Deletes an entry',
        'type' => 'write',
        'capabilities' => 'tool/mitxel:edit',
        'ajax' => true,
    ),
    'tool_mitxel_entries_list' => array(
        'classname' => 'tool_mitxel_external',
        'methodname' => 'entries_list',
        'description' => 'Returns list of entries',
        'type' => 'read',
        'capabilities' => 'tool/mitxel:view',
        'ajax' => true,
    ),
);
