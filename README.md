# EduCheckout enrolment (enrol_educheckout)

EduCheckout enrolment is the enrolment method used by the
[local_educheckout](https://github.com/verzog/moodle-local_educheckout) storefront.
When a learner completes a purchase, the storefront enrols them into the purchased
course(s) through this plugin; group assignment and enrolment duration are
configured per product variation.

It is a minimal, standards-conformant derivative of Moodle's core manual
enrolment plugin.

**Version 1.0.0 — Moodle 5.0+ / PHP 8.2+**

## The EduCheckout plugin suite

EduCheckout is a collection of four Moodle plugins that together provide a
self-hosted course store:

| Plugin | Type | Purpose |
|---|---|---|
| [`local_educheckout`](https://github.com/verzog/moodle-local_educheckout) | Local | Storefront: catalogue, cart, checkout, orders |
| `enrol_educheckout` *(this repo)* | Enrolment | Enrols learners into courses on purchase |
| [`block_educheckout`](https://github.com/verzog/moodle-block_educheckout) | Block | Sidebar block with catalogue link and mini cart |
| [`theme_educheckout`](https://github.com/verzog/moodle-theme_educheckout) | Theme | Optional branded theme for the storefront pages |

## Features

- **Post-payment enrolment** — called by `local_educheckout` on successful
  payment; enrols the learner into the purchased Moodle course automatically.
- **Per-variation group assignment** — each product variation can target a
  specific Moodle group; learners are added to the correct group on enrolment.
- **Enrolment duration** — per-variation duration in days (0 = no expiry).
- **Expiry actions** — configurable behaviour when an enrolment expires:
  keep access, suspend and remove roles, or fully unenrol the learner.
- **Expiry notifications** — sends Moodle messages to learners before their
  enrolment expires; the notification hour is configurable.
- **Standard Moodle enrolment** — appears in course enrolment lists and is
  compatible with standard Moodle enrolment management tools.

## Requirements

- Moodle 5.0 or later.
- PHP 8.2 or later.
- The `local_educheckout` storefront plugin (which declares this plugin as a
  dependency).

## Installing via uploaded ZIP file

1. Log in to your Moodle site as an admin and go to
   _Site administration > Plugins > Install plugins_.
2. Upload the ZIP file. You should only be prompted to add extra details if
   your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

> **Note:** Install this plugin before (or alongside) `local_educheckout`.
> The storefront declares `enrol_educheckout` as a dependency and the installer
> will warn if it is missing.

## Installing manually

The plugin can also be installed by putting the contents of this directory into

    {your/moodle/dirroot}/enrol/educheckout

Then, log in to your Moodle site as an admin and go to
_Site administration > Notifications_ to complete the installation.

## Configuration

Go to _Site administration > Plugins > Enrolments > EduCheckout enrolment_.

| Setting | Description |
|---|---|
| Default status | Whether new enrolment instances are enabled by default. |
| Default role | Role assigned to enrolled learners (default: Student). |
| Default enrolment duration | Duration before enrolment expires (0 = unlimited). |
| Expired action | What to do when an enrolment expires: keep access, suspend and remove roles, or unenrol the learner. |
| Expiry notification hour | Hour of day (site time) at which expiry notification messages are sent. |

## Credits and acknowledgements

EduCheckout enrolment is a rename and continuation of the **Moodec enrolment
plugin** (`enrol_moodec`) originally written in 2015 by **Thomas Threadgold**
at **LearningWorks Ltd**
([github.com/LearningWorks](https://github.com/LearningWorks)). The plugin
itself is in turn a derivative of Moodle's core **manual enrolment plugin**
(`enrol_manual`), originally written by **Petr Skoda** ([skodak.org](http://skodak.org)).

Sincere thanks to both for the prior art this codebase is built on.

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
Copyright (C) 2010 Petr Skoda; original Moodec enrolment plugin,
Copyright (C) 2015 Thomas Threadgold / LearningWorks Ltd; renaming and
ongoing maintenance Copyright (C) 2026 the EduCheckout contributors.
