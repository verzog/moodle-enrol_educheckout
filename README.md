# Moodec enrolment (enrol_moodec)

Moodec enrolment is the enrolment method used by the
[local_moodec](https://github.com/verzog/moodle-local_moodec) storefront. When a
learner completes a purchase, the storefront enrols them into the purchased
course(s) through this plugin (group assignment and enrolment duration are
handled per product).

It is a minimal, standards-conformant derivative of Moodle's core manual
enrolment plugin, targeting **Moodle 5.0+ / PHP 8.2+**.

## Requirements

- Moodle 5.0 or later.
- The `local_moodec` storefront plugin (which declares this plugin as a
  dependency).

## Installing via uploaded ZIP file

1. Log in to your Moodle site as an admin and go to
   _Site administration > Plugins > Install plugins_.
2. Upload the ZIP file. You should only be prompted to add extra details if
   your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually

The plugin can also be installed by putting the contents of this directory into

    {your/moodle/dirroot}/enrol/moodec

Then, log in to your Moodle site as an admin and go to
_Site administration > Notifications_ to complete the installation.

## License

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program. If not, see <https://www.gnu.org/licenses/>.

Derived from the Moodle core manual enrolment plugin,
Copyright (C) 2010 Petr Skoda; modifications Copyright (C) 2026 LearningWorks Ltd.
