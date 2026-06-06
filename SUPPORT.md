# EduCheckout — Support

Support options for the EduCheckout plugin suite (`local_educheckout`,
`enrol_educheckout`, `theme_educheckout`, `block_educheckout`),
published by EduCheckout / Vernon Spain ([educheckout.com](https://educheckout.com)).

There are two ways to get help: **free community support** (best-effort)
and **optional paid support** (a commercial service). The plugins
themselves are free software under GPLv3 either way — paid support buys
you *our time and a response commitment*, never the right to run the
software. You already have that.

---

## Free community support

Available to everyone, no purchase required:

| Channel | Use for |
|---------|---------|
| The plugin's GitHub issue tracker | Bug reports, feature requests, documentation fixes. |
| The plugin's GitHub security advisories ("Report a vulnerability") | Suspected security issues — please do **not** open a public issue. |

Free support is **best-effort and as-available**: we read every report
and fix confirmed bugs in a future release when we can, but there is no
guaranteed response time and no commitment to fix any particular issue.

When reporting a bug, please include:

- Moodle version (*Site administration → Notifications*).
- PHP version (`php -v`).
- Plugin version (`$plugin->release` from `version.php`).
- The steps to reproduce, and any relevant lines from your web server
  error log around the failure.

---

## Paid support (optional)

If you need more than best-effort — a guaranteed response, help standing
the storefront up, or work on your timeline — EduCheckout offers paid
support as a separate commercial service.

### Who it's for

- Institutions running EduCheckout in production that need a dependable
  response time.
- Teams that want help with **installation, upgrades, and configuration**
  — including wiring up Moodle's core Payments (`core_payment`) gateways,
  enrolment and group mappings, and the storefront catalogue.
- Anyone who needs a **specific fix, feature, or integration** delivered
  to a deadline rather than "in a future release, eventually".

### What it can include

- **Priority response** against an agreed target time.
- **Guided install / upgrade / configuration** for the EduCheckout suite.
- **Payment-gateway and enrolment setup** assistance.
- **Prioritised bug fixes** and **custom feature development** (scoped and
  quoted separately).
- **Supported-version guidance** for your Moodle and PHP roadmap.

### Indicative options *(pricing [TBC])*

| Option | Best for | Price |
|--------|----------|-------|
| Pay-as-you-go incident | A one-off problem or install | `[TBC]` |
| Support retainer (monthly/annual) | Ongoing priority support + a response SLA | `[TBC]` |
| Custom development | A specific feature or integration | Quoted per scope |

> These options are indicative and will be confirmed on the EduCheckout
> website. Nothing here is a binding offer until agreed in writing.

### How to request paid support

- Web: **[TBC — e.g. https://educheckout.com/support]**
- Email: **[TBC — e.g. support@educheckout.com]**

Tell us the plugin and version, your Moodle/PHP versions, and a short
description of what you need, and we'll come back with scope, timing, and
a quote.

---

## What paid support does *not* change

- **The software stays GPLv3.** Paid support is a service contract layered
  on top of the licence. It does not add any restriction to your right to
  use, study, modify, fork, or redistribute the plugins, and it is not a
  licence key — there is no activation or phone-home in the code.
- **No lock-in.** You can stop a retainer at any time; your installed
  plugins keep working forever, and free community support remains open to
  you.
- **Billing and refunds** for any paid support are handled directly by
  EduCheckout as Merchant of Record — see each plugin's `TERMS.md` and the
  EduCheckout website for current terms.

---

## What we generally don't cover under free support

To keep the free surface bounded (these are good candidates for paid
support instead):

- **Custom forks.** If you modify the source (your right under GPLv3) and
  the change causes the bug, the fix is yours — we'll help identify
  whether the issue is upstream.
- **Modified Moodle core.** We test against vanilla Moodle.
- **Hosting/infrastructure quirks** — reverse proxies, WAFs, or filesystem
  permission setups outside Moodle's documented requirements.
- **End-of-life PHP or Moodle versions.**
