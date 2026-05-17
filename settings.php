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
 * Admin settings for the moodec enrolment plugin.
 *
 * @package    enrol_moodec
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @copyright  2026 LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $setting = new admin_setting_configselect(
        'enrol_moodec/status',
        get_string('status', 'enrol_moodec'),
        get_string('status_desc', 'enrol_moodec'),
        ENROL_INSTANCE_ENABLED,
        [
            ENROL_INSTANCE_ENABLED => get_string('yes'),
            ENROL_INSTANCE_DISABLED => get_string('no'),
        ]
    );
    $settings->add($setting);

    if (!during_initial_install()) {
        $options = get_default_enrol_roles(context_system::instance());
        $student = get_archetype_roles('student');
        $student = reset($student);
        $setting = new admin_setting_configselect(
            'enrol_moodec/roleid',
            get_string('defaultrole', 'enrol_moodec'),
            get_string('defaultrole_desc', 'enrol_moodec'),
            $student ? $student->id : null,
            $options
        );
        $settings->add($setting);
    }

    $setting = new admin_setting_configduration(
        'enrol_moodec/enrolperiod',
        get_string('enrolperiod', 'enrol_moodec'),
        get_string('enrolperiod_desc', 'enrol_moodec'),
        0
    );
    $settings->add($setting);

    $setting = new admin_setting_configselect(
        'enrol_moodec/expiredaction',
        get_string('expiredaction', 'enrol_moodec'),
        get_string('expiredaction_help', 'enrol_moodec'),
        ENROL_EXT_REMOVED_KEEP,
        [
            ENROL_EXT_REMOVED_KEEP => get_string('extremovedkeep', 'core_enrol'),
            ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string('extremovedsuspendnoroles', 'core_enrol'),
            ENROL_EXT_REMOVED_UNENROL => get_string('extremovedunenrol', 'core_enrol'),
        ]
    );
    $settings->add($setting);

    $hours = [];
    for ($i = 0; $i < 24; $i++) {
        $hours[$i] = $i;
    }
    $setting = new admin_setting_configselect(
        'enrol_moodec/expirynotifyhour',
        get_string('expirynotifyhour', 'enrol_moodec'),
        get_string('expirynotifyhour_desc', 'enrol_moodec'),
        6,
        $hours
    );
    $settings->add($setting);
}
