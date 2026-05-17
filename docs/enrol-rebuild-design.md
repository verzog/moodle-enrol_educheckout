# enrol_moodec Rebuild — Design (for review)

Status: **DESIGN ONLY — no implementation in this PR.** Companion to the
`local_moodec` cart rebuild (`verzog/moodle-local_moodec` PR #1). Governed by the
same AU Moodle plugin standard; **target Moodle 5.0+ / PHP 8.2+**.

## 1. Why this exists

`local_moodec`'s new cart enrols buyers by calling
`enrol_get_plugin('moodec')->enrol_user(...)` against a `moodec` enrol instance
on each purchased course. That requires `enrol_moodec` to be a clean, installable
Moodle 5.0+ enrolment plugin. Today it is not:

- `version.php` still declares 2014 metadata (`version 2014111000`,
  `requires 2014110400`) — it will not register as 5.0-compatible.
- It is a near-verbatim **sed-renamed clone of core `enrol_manual`**
  ("manual" → "moodec"), including mangled artefacts (`"moodecly moodecly"`,
  `lasternoller`, `lasternollerinstanceid`).
- It carries the entire manual-enrol surface — **YUI** quick-enrolment
  (`yui/`, `ajax.php`, `M.enrol_moodec.quickenrolment`), ad-hoc
  `externallib.php` + `db/services.php`, bulk operations (`locallib.php`,
  `bulkchangeforms.php`), and a bespoke `manage.php`. YUI is removed from modern
  Moodle; most of this is dead weight for a cart-driven enrolment and a large
  coding-standards/maintenance liability.
- Tabs for indentation (Moodle CS requires 4 spaces); non-standard headers.

## 2. Approach: minimal, conformant payment-enrolment plugin

Rebuild as the smallest correct enrolment plugin the cart needs, modelled on the
**current** core `enrol_manual` (Moodle 5.0+), not the 2010 clone. Admin
edit/unenrol continues to work through the **core** enrolment pages
(`/enrol/editenrolment.php`, `/enrol/unenroluser.php`) which the plugin already
links to — so the bespoke YUI/AJAX UI can be dropped without losing admin
enrol management.

### Keep / rebuild (conformant)

- `lib.php` — `enrol_moodec_plugin extends enrol_plugin`: instance management
  (one instance per course), `enrol_user`/`unenrol_user`,
  `roles_protected`/`allow_*`, `get_user_enrolment_actions` (core edit/unenrol
  pages), `can_*_instance`, restore/backup hooks, expiry handling. Strip the
  sed-mangling; retain real logic.
- `edit.php` + `edit_form.php` — standard instance edit form (status, default
  role, enrol period, expiry notify/threshold).
- `settings.php` — admin defaults (status, role, enrol period, expiry).
- `db/access.php` — the five capabilities (kept; cleaned).
- `db/install.php` (default-instance-on-existing-courses), `db/upgrade.php`
  (incrementing savepoints from a 5.0 baseline).
- `lang/en/enrol_moodec.php` — ascending byte order, no section comments,
  AU/UK spelling ("Enrolment").
- `version.php` — standard Moodle header, `component = enrol_moodec`, bumped
  `version`, `requires` = Moodle 5.0 baseline, `maturity`. No legacy
  `$plugin->cron`.
- **New** `classes/task/sync_enrolments.php` — scheduled task replacing the
  legacy `cron()`/`$plugin->cron` for expiry sync (the modern enrol pattern),
  registered in `db/tasks.php`.
- **New** `privacy/classes/provider.php` — implement the Privacy API (model on
  core `enrol_manual`; enrolment data is core-owned, declare accordingly) for
  APP compliance.
- `classes/` autoloaded, namespaced; `MOODLE_INTERNAL` guard on class/exec
  files (not lang).

### Drop (dead weight / superseded by core)

- `yui/` and `ajax.php` — YUI quick-enrolment UI (removed-tech; admin enrol is
  handled by core UI).
- `externallib.php` + `db/services.php` — bespoke web services not used by the
  cart (the cart calls the PHP enrol API directly).
- `locallib.php` + `bulkchangeforms.php` + `manage.php` — bespoke bulk/manage
  UI; core enrolment manager covers admin needs for v1. (If course-level bulk
  ops are wanted later, re-add via the modern core bulk-operation API — flagged,
  not v1.)
- `unenrolself.php` — self-unenrol page; the `enrol/moodec:unenrolself`
  capability is retained but self-unenrol (if needed) routes through standard
  course unenrol. Confirm whether buyers should be able to self-unenrol
  (Open Question 1).

## 3. Legal / attribution (carry-over from the licensing review)

- This is GPL-derived from Moodle core `enrol_manual`. **Retain the
  `2010 Petr Skoda` copyright** alongside the new maintainer/`LearningWorks`
  copyright in every rebuilt file header — removing upstream attribution would
  be a GPL/attribution violation. License stays GPL v3+.

## 4. Packaging, CI, versioning

- Own `.github/workflows/moodle-ci.yml` (from `moodle-plugin-ci`
  `gha.dist.yml`), `env: TZ: Australia/Sydney`, matrix PHP 8.2/8.3 ×
  `mysqli`/`pgsql`, Moodle 5.0+ branches, warnings-as-failures.
- README to the `tool_pluginskel` template; GPLv3 block matching headers.
- `local_moodec`'s `version.php` dependency on `enrol_moodec` is bumped to this
  rebuild's new version (coordinated across the two PRs).
- Implementation merges into the `moodle_enrol_moodec50` branch (mirrors the
  `local_moodec` Decision 1 of targeting its `Moodle-Local_moodle5.0` branch);
  confirm (Open Question 2).

## 5. Tests

- PHPUnit (`advanced_testcase`, `resetAfterTest`): add/one-instance-only,
  enrol/unenrol, expiry sync task (timeend in past → suspend/unenrol per
  `expiredaction`), restore hooks.
- Behat: add the Moodec enrolment method to a course; verify a user enrolled by
  the cart appears active; expiry suspends access. DD/MM/YYYY in scenarios.

## 6. Open questions

1. **Self-unenrol**: should buyers be able to self-unenrol from a purchased
   course (keep a minimal self-unenrol path), or is unenrol admin-only?
   Recommended: admin-only for a paid enrolment (no self-unenrol page).
2. **Target branch**: confirm implementation merges into
   `moodle_enrol_moodec50` (mirroring the `local_moodec` 5.0 branch choice).
3. **Bulk operations**: confirm course-level bulk enrol/edit is **not** needed
   for v1 (re-add later via the modern core bulk API if required).
