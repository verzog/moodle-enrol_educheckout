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

declare(strict_types=1);

/**
 * CLI script for syncing Moodec enrolments and sending expiry notifications.
 *
 * @package    enrol_moodec
 * @copyright  2012 Petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/clilib.php');

// Define CLI options.
[$options, $unrecognized] = cli_get_params(
    ['verbose' => false, 'help' => false],
    ['v' => 'verbose', 'h' => 'help']
);

if (!empty($unrecognized)) {
    cli_error(get_string('cliunknowoption', 'admin', implode("\n  ", $unrecognized)));
}

if (!empty($options['help'])) {
    $help = <<<EOT
Execute Moodec enrolment expiration sync and send notifications.

Options:
-v, --verbose         Print verbose progress information
-h, --help            Show this help message

Example:
\$ sudo -u www-data /usr/bin/php local/moodec/cli/sync.php
EOT;

    cli_writeln($help);
    exit(0);
}

if (!enrol_is_enabled('moodec')) {
    cli_error('enrol_moodec plugin is disabled. Synchronisation aborted.', 2);
}

// Create progress trace depending on verbosity.
$trace = !empty($options['verbose']) ? new text_progress_trace() : new null_progress_trace();

// Load the plugin and execute sync + expiry notifications.
$plugin = enrol_get_plugin('moodec');

if (!$plugin) {
    cli_error('Moodec enrolment plugin could not be loaded.', 3);
}

$result = $plugin->sync($trace);
$plugin->send_expiry_notifications($trace);

exit($result);
