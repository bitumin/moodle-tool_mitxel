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
 * API tests.
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * API tests.
 *
 * @package    tool_mitxel
 * @copyright  2018 Mitxel Moriana <mitxel@tresipunt.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_mitxel_api_testcase extends advanced_testcase {
    /**
     * Set up for the tests.
     */
    public function setUp() {
        $this->resetAfterTest();
    }

    /**
     * Test for tool_mitxel_api::insert and tool_mitxel_api::retrieve
     */
    public function test_insert() {
        $course = self::getDataGenerator()->create_course();

        $entryid = tool_mitxel_api::insert((object) [
            'courseid' => $course->id,
            'name' => 'testname1',
            'completed' => 1,
            'priority' => 0
        ]);

        $entry = tool_mitxel_api::retrieve($entryid);
        $this->assertEquals($course->id, $entry->courseid);
        $this->assertEquals('testname1', $entry->name);
    }

    /**
     * Test for tool_mitxel_api::update
     */
    public function test_update() {
        $course = self::getDataGenerator()->create_course();
        $entryid = tool_mitxel_api::insert((object) [
            'courseid' => $course->id,
            'name' => 'testname1'
        ]);

        tool_mitxel_api::update((object) [
            'id' => $entryid,
            'name' => 'testname2'
        ]);

        $entry = tool_mitxel_api::retrieve($entryid);
        $this->assertEquals($course->id, $entry->courseid);
        $this->assertEquals('testname2', $entry->name);
    }

    /**
     * Test for tool_mitxel_api::delete
     */
    public function test_delete() {
        $course = self::getDataGenerator()->create_course();
        $entryid = tool_mitxel_api::insert((object) [
            'courseid' => $course->id,
            'name' => 'testname1'
        ]);

        tool_mitxel_api::delete($entryid);

        $entry = tool_mitxel_api::retrieve($entryid, 0, IGNORE_MISSING);
        $this->assertEmpty($entry);
    }
}
