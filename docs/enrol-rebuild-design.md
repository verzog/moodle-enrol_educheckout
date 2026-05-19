# enrol_educheckout Rebuild — Design (for review)

Status: **DESIGN ONLY — no implementation in this PR.** Companion to the
`local_educheckout` cart rebuild (`verzog/moodle-local_educheckout` PR #1). Governed by the
same AU Moodle plugin standard; **target Moodle 5.0+ / PHP 8.2+**. Open questions
resolved (§6).

## 1. Why this exists

`local_educheckout`'s new cart enrols buyers by calling
`enrol_get_plugin('educheckout')->enrol_user(...)` against a `educheckout` enrol instance
on each purchased course. That requires `enrol_educheckout` to be a clean, installable
Moodle 5.0+ enrolment plugin. Today it is not:

- `version.php` still declares 2014 metadata (`version 2014111000`,
  `requires 2014110400`) — it will not register as 5.0-compatible.
- It is a near-verbatim **sed-renamed clone of core `enrol_manual`**
  ("manual" → "educheckout"), including mangled artefacts (`"moodecly moodecly"`,
  `lasternoller`, `lasternollerinstanceid`).
- It carries the entire manual-enrol surface — **YUI** quick-enrolment
  (`yui/`, `ajax.php`, `M.enrol_educheckout.quickenrolment`), ad-hoc
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

- `lib.php` — `enrol_educheckout_plugin extends enrol_plugin`: instance management
  (one instance per course), `enrol_user`/`unenrol_user`,
  `roles_protected`/`allow_*`, `get_user_enrolment_actions` (core edit/unenrol
  pages), `can_*_instance`, restore/backup hooks, expiry handling. Strip the
  sed-mangling; retain real logic.
- `edit.php` + `edit_form.php` — standard instance edit form (status, default
  role, enrol period, expiry notify/threshold).
- `settings.php` — admin defaults (status, role, enrol period, expiry).
- `db/access.php` — capabilities, **cleaned and reduced**: drop
  `enrol/educheckout:unenrolself` (self-unenrol is not offered — see §6.1). Keep
  `config`, `enrol`, `manage`, `unenrol`.
- `db/install.php` (default-instance-on-existing-courses), `db/upgrade.php`
  (incrementing savepoints from a 5.0 baseline).
- `lang/en/enrol_educheckout.php` — ascending byte order, no section comments,
  AU/UK spelling ("Enrolment").
- `version.php` — standard Moodle header, `component = enrol_educheckout`, bumped
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
  UI. Course-level bulk operations are **confirmed not needed for v1** (§6.3);
  core enrolment manager covers admin needs. (Re-add later via the modern core
  bulk-operation API if ever required.)
- `unenrolself.php` — self-unenrol page. **Confirmed: buyers cannot
  self-unenrol** from a paid enrolment (§6.1); page and capability removed.

## 3. Legal / attribution (carry-over from the licensing review)

- This is GPL-derived from Moodle core `enrol_manual`. **Retain the
  `2010 Petr Skoda` copyright** alongside the new maintainer/`LearningWorks`
  copyright in every rebuilt file header — removing upstream attribution would
  be a GPL/attribution violation. License stays GPL v3+.

## 4. Packaging, CI, versioning

- Own `.github/workflows/moodle-ci.yml` (from `moodle-plugin-ci`
  `gha.dist.yml`), `env: TZ: Australia/Sydney`, matrix PHP 8.2/8.3 ×
  `mysqli`/`pgsql`, Moodle 5.0+ branches, warnings-as-failures, triggered on
  `main`.
- README to the `tool_pluginskel` template; GPLv3 block matching headers.
- `local_educheckout`'s `version.php` dependency on `enrol_educheckout` is bumped to this
  rebuild's new version (coordinated across the two PRs).
- **Integration branch: `main`** (project-wide standardisation — see
  `local_educheckout` design §11 / Decision 1). This supersedes the earlier
  `moodle_enrol_educheckout50` target. `main` is created/standardised as the
  Moodle 5.0+ integration line; making it the repo default is a one-off GitHub
  admin step done at implementation start.

## 5. Tests

- PHPUnit (`advanced_testcase`, `resetAfterTest`): add/one-instance-only,
  enrol/unenrol, expiry sync task (timeend in past → suspend/unenrol per
  `expiredaction`), restore hooks.
- Behat: add the EduCheckout enrolment method to a course; verify a user enrolled by
  the cart appears active; expiry suspends access. DD/MM/YYYY in scenarios.

## 6. Resolved decisions

1. **Self-unenrol — admin-only.** Buyers cannot self-unenrol from a paid
   enrolment. `unenrolself.php` and the `enrol/educheckout:unenrolself` capability
   are removed; unenrol is performed by admins/teachers via the core enrolment
   pages.
2. **Target branch — confirmed.** Implementation integrates on **`main`**
   (project standardised on `main`; supersedes `moodle_enrol_educheckout50`).
3. **Bulk operations — not in v1.** Course-level bulk enrol/edit is out of
   scope; can be re-added later via the modern core bulk API if needed.
