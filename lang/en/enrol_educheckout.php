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
 * Strings for the educheckout enrolment plugin.
 *
 * @package    enrol_educheckout
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @copyright  2026 Vernon Spain
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['cost'] = 'Enrolment fee';
$string['cost_desc'] = 'Default fee per buyer when a new EduCheckout enrolment instance is added to a course. Course teams can change the fee per course on the enrolment instance.';
$string['cost_help'] = 'Fee charged per buyer for this course. Variation prices on a storefront product override this when "use variation pricing" is enabled.';
$string['costerror'] = 'The enrolment fee must be a non-negative number.';
$string['currency'] = 'Currency';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select the role which should be assigned to users enrolled via EduCheckout.';
$string['educheckout:config'] = 'Configure EduCheckout enrolment instances';
$string['educheckout:enrol'] = 'Enrol users into a course via EduCheckout';
$string['educheckout:manage'] = 'Manage enrolled users';
$string['educheckout:unenrol'] = 'Unenrol users from the course';
$string['enrolperiod'] = 'Default enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that an enrolment is valid. If set to zero, the enrolment duration is unlimited by default.';
$string['expiredaction'] = 'Enrolment expiry action';
$string['expiredaction_help'] = 'Select the action to carry out when a user enrolment expires. Note that some user data and settings are purged from the course during course unenrolment.';
$string['expirymessageenrolledbody'] = 'Dear {$a->user},

This is a notification that your enrolment in the course \'{$a->course}\' is due to expire on {$a->timeend}.

If you need help, please contact {$a->enroller}.';
$string['expirymessageenrolledsubject'] = 'EduCheckout enrolment expiry notification';
$string['expirymessageenrollerbody'] = 'EduCheckout enrolment in the course \'{$a->course}\' will expire within the next {$a->threshold} for the following users:

{$a->users}

To extend their enrolment, go to {$a->extendurl}.';
$string['expirymessageenrollersubject'] = 'EduCheckout enrolment expiry notification';
$string['expirynotifyhour'] = 'Hour to send enrolment expiry notifications';
$string['expirynotifyhour_desc'] = 'The hour of the day at which enrolment expiry notifications are sent.';
$string['messageprovider:expiry_notification'] = 'EduCheckout enrolment expiry notifications';
$string['pluginname'] = 'EduCheckout enrolment';
$string['privacy:metadata'] = 'The EduCheckout enrolment plugin does not store any personal data; it relies on the core enrolment subsystem.';
$string['status'] = 'Enable EduCheckout enrolments';
$string['status_desc'] = 'Allow course access to users enrolled via the EduCheckout storefront.';
$string['tasksyncenrolments'] = 'Synchronise EduCheckout enrolment expirations';
