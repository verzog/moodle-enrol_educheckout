<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Tests for the educheckout enrolment plugin.
 *
 * @package    enrol_educheckout
 * @copyright  2026 Vernon Spain
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_educheckout;

/**
 * Unit tests for enrol_educheckout_plugin.
 *
 * @covers \enrol_educheckout_plugin
 */
final class enrol_test extends \advanced_testcase {
    /**
     * The plugin resolves and only one instance is allowed per course.
     *
     * @return void
     */
    public function test_single_instance_per_course(): void {
        global $DB;
        $this->resetAfterTest();

        $plugin = enrol_get_plugin('educheckout');
        $this->assertInstanceOf(\enrol_educheckout_plugin::class, $plugin);

        $course = $this->getDataGenerator()->create_course();

        $instanceid = $plugin->add_instance($course);
        $this->assertNotNull($instanceid);
        $this->assertEquals(1, $DB->count_records('enrol', ['courseid' => $course->id, 'enrol' => 'educheckout']));

        $this->assertNull($plugin->add_instance($course));
        $this->assertEquals(1, $DB->count_records('enrol', ['courseid' => $course->id, 'enrol' => 'educheckout']));
    }

    /**
     * Users can be enrolled and unenrolled through the plugin.
     *
     * @return void
     */
    public function test_enrol_and_unenrol_user(): void {
        global $DB;
        $this->resetAfterTest();

        $plugin = enrol_get_plugin('educheckout');
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();

        $instanceid = $plugin->add_instance($course);
        $instance = $DB->get_record('enrol', ['id' => $instanceid], '*', MUST_EXIST);
        $context = \context_course::instance($course->id);

        $plugin->enrol_user($instance, $user->id, null, 0, 0, ENROL_USER_ACTIVE);
        $this->assertTrue(is_enrolled($context, $user));

        $plugin->unenrol_user($instance, $user->id);
        $this->assertFalse(is_enrolled($context, $user));
    }
}
