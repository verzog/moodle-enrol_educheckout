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
 * Strings for the moodec enrolment plugin.
 *
 * @package    enrol_moodec
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @copyright  2026 LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select the role which should be assigned to users enrolled via Moodec.';
$string['enrolperiod'] = 'Default enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that an enrolment is valid. If set to zero, the enrolment duration is unlimited by default.';
$string['expiredaction'] = 'Enrolment expiry action';
$string['expiredaction_help'] = 'Select the action to carry out when a user enrolment expires. Note that some user data and settings are purged from the course during course unenrolment.';
$string['expirymessageenrolledbody'] = 'Dear {$a->user},

This is a notification that your enrolment in the course \'{$a->course}\' is due to expire on {$a->timeend}.

If you need help, please contact {$a->enroller}.';
$string['expirymessageenrolledsubject'] = 'Moodec enrolment expiry notification';
$string['expirymessageenrollerbody'] = 'Moodec enrolment in the course \'{$a->course}\' will expire within the next {$a->threshold} for the following users:

{$a->users}

To extend their enrolment, go to {$a->extendurl}.';
$string['expirymessageenrollersubject'] = 'Moodec enrolment expiry notification';
$string['expirynotifyhour'] = 'Hour to send enrolment expiry notifications';
$string['expirynotifyhour_desc'] = 'The hour of the day at which enrolment expiry notifications are sent.';
$string['messageprovider:expiry_notification'] = 'Moodec enrolment expiry notifications';
$string['moodec:config'] = 'Configure Moodec enrolment instances';
$string['moodec:enrol'] = 'Enrol users into a course via Moodec';
$string['moodec:manage'] = 'Manage enrolled users';
$string['moodec:unenrol'] = 'Unenrol users from the course';
$string['pluginname'] = 'Moodec enrolment';
$string['privacy:metadata'] = 'The Moodec enrolment plugin does not store any personal data; it relies on the core enrolment subsystem.';
$string['status'] = 'Enable Moodec enrolments';
$string['status_desc'] = 'Allow course access to users enrolled via the Moodec storefront.';
$string['tasksyncenrolments'] = 'Synchronise Moodec enrolment expirations';
