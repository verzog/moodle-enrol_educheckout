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
 * Install steps for the educheckout enrolment plugin.
 *
 * One-shot migration from the legacy enrol_moodec plugin: rename existing
 * mdl_enrol rows, role_capabilities, plugin config, and drop stale scheduled
 * tasks / message providers that belonged to enrol_moodec. Runs only once on
 * first install of enrol_educheckout. A clean install (no prior moodec data)
 * is a no-op.
 *
 * @package    enrol_educheckout
 * @copyright  2026 the EduCheckout contributors
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Migrate any leftover enrol_moodec data to enrol_educheckout.
 */
function xmldb_enrol_educheckout_install() {
    global $DB;

    $DB->set_field('enrol', 'enrol', 'educheckout', ['enrol' => 'moodec']);

    $DB->set_field('config_plugins', 'plugin', 'enrol_educheckout', ['plugin' => 'enrol_moodec']);

    $caps = $DB->get_records_sql(
        "SELECT id, capability FROM {role_capabilities} WHERE " . $DB->sql_like('capability', '?'),
        ['enrol/moodec:%']
    );
    foreach ($caps as $row) {
        $new = 'enrol/educheckout:' . substr($row->capability, strlen('enrol/moodec:'));
        $DB->set_field('role_capabilities', 'capability', $new, ['id' => $row->id]);
    }

    $DB->delete_records('task_scheduled', ['component' => 'enrol_moodec']);
    $DB->delete_records('message_providers', ['component' => 'enrol_moodec']);
    $DB->delete_records_select(
        'capabilities',
        $DB->sql_like('name', '?'),
        ['enrol/moodec:%']
    );
}
