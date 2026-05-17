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
 * Scheduled task that syncs moodec enrolment expirations.
 *
 * @package    enrol_moodec
 * @copyright  2026 LearningWorks Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_moodec\task;

/**
 * Replaces the legacy enrol cron() for expiry handling.
 */
class sync_enrolments extends \core\task\scheduled_task {
    /**
     * Returns the task name shown in the scheduled tasks admin UI.
     *
     * @return string
     */
    public function get_name() {
        return get_string('tasksyncenrolments', 'enrol_moodec');
    }

    /**
     * Run the moodec enrolment expiry sync.
     *
     * @return void
     */
    public function execute() {
        $plugin = enrol_get_plugin('moodec');
        if (!$plugin) {
            return;
        }
        $trace = new \text_progress_trace();
        $plugin->sync($trace, null);
        $plugin->send_expiry_notifications($trace);
        $trace->finished();
    }
}
