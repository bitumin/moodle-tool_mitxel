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

$url = new moodle_url('/admin/tool/mitxel/index.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('helloworld', 'tool_mitxel'));
$PAGE->set_heading(get_string('pluginname', 'tool_mitxel'));

//echo get_string('helloworld', 'tool_mitxel');

//$userinput = 'no <b>tags</b> allowed in strings';
//$userinput = '<span class="multilang" lang="en">RIGHT</span><span class="multilang" lang="fr">WRONG</span>';
//$userinput = '<script>alert("hello world!")</script>';
//$userinput = '3>2';
$userinput = '2<3'; // Interesting effect, huh?

echo html_writer::div(s($userinput)); // Used when you want to escape the value.
echo html_writer::div(format_string($userinput)); // Used for one-line strings, such as forum post subject.
echo html_writer::div(format_text($userinput)); // Used for multil-line rich-text contents such as forum post body.
// format_text applies multilang filter.
// None runs inline javascript code.
// format_string filters out <3 (smiley?)
