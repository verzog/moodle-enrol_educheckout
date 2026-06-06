# EduCheckout enrolment — Terms of Sale

These Terms of Sale govern the **purchase transaction** for the Moodle
plugin **EduCheckout enrolment** (`enrol_educheckout`) when bought
through Moodle Marketplace from EduCheckout (trading as Vernon Spain),
ABN/ACN as published on [educheckout.com](https://educheckout.com)
("EduCheckout", "we", "us").

They cover the commercial relationship only — the price you pay, what
you get in return, refunds, and the support obligation. They do **not**
restrict your rights to the underlying software, which is licensed
separately under the GNU General Public License, version 3 or later
("GPLv3"). Where any clause below appears to conflict with GPLv3, GPLv3
prevails and the conflicting clause is severable.

## 1. The software is GPLv3

EduCheckout enrolment is free software. The full source is published at
<https://github.com/verzog/moodle-enrol_educheckout> under GPLv3.

Nothing in these Terms of Sale:

- restricts your right to **use** the software for any purpose;
- restricts your right to **study, modify, or fork** the source;
- restricts your right to **redistribute** the software, modified or
  unmodified, to any third party, with or without charge;
- requires you to pay a recurring licence fee, accept a licence-key
  check, or accept a phone-home / activation mechanism (there is none
  in the code, and we will not add one).

If you obtain a copy of the source from GitHub, build it, and install
it on a Moodle site, **you owe us nothing**. That is your right under
GPLv3 and we are not going to chase you for it.

## 2. What the Marketplace purchase actually buys

A Marketplace purchase is, in effect, a **convenience-and-goodwill
transaction**. For the single one-off price shown at checkout, you
receive:

1. The current tagged release, delivered through Moodle Marketplace's
   install flow, with the vendor signature and Marketplace vetting
   intact.
2. **Update delivery** through Marketplace for as long as Marketplace
   continues to carry the plugin and we continue to publish releases.
3. **Best-effort bug fixes**, as and when they become available,
   published through the channels in section 13. This is the only
   support the purchase carries — we do not undertake to fix any
   particular issue, to respond within any timeframe, or to provide
   installation, configuration, customisation, or other assistance.
4. A clean record-of-purchase invoice/receipt from EduCheckout, useful
   for institutional procurement.

You are **not** buying:

- A perpetual licence to the software (you already have that under
  GPLv3 — no purchase needed).
- An exclusive or proprietary right.
- A warranty of fitness, merchantability, or non-infringement beyond
  the non-excludable consumer guarantees described in section 7.
- A guarantee of future releases. We may stop publishing the plugin;
  see section 6.
- Any guaranteed support, maintenance, feature development, or committed
  response time. Bug fixes are provided on a best-effort, as-available
  basis only, with no obligation to fix any given issue.

## 3. Price, currency, taxes

- Prices are displayed at checkout in the currency Marketplace presents
  to you, inclusive or exclusive of tax as Marketplace's flow indicates.
- EduCheckout is the **Merchant of Record** for Marketplace purchases of
  EduCheckout enrolment. We issue the receipt; we are responsible for
  collecting and remitting any applicable GST/VAT/sales tax in the
  jurisdictions where we are registered.
- The single price covers a single Moodle site installation **as a
  matter of pricing fairness, not licence restriction.** GPLv3 lets you
  copy the plugin to any number of sites; we simply ask, in good faith,
  that organisations running the plugin on multiple distinct production
  sites buy one copy per site. There is no technical enforcement of
  this and no audit clause.

## 4. Delivery

Delivery is electronic and occurs when Marketplace makes the plugin
available to your site for install. No physical goods ship. If
Marketplace's install flow fails for reasons attributable to us
(corrupt package, missing dependency we declared, signing failure on
our side), contact us per section 13 and we will re-deliver or refund
at your option.

## 5. Refunds

- **14-day no-questions-asked refund.** If, within 14 calendar days of
  the purchase date shown on your EduCheckout receipt, you decide the
  plugin is not for you, email the address on your receipt with the
  order number and we will refund the full purchase price.
- **Defect-based refund.** If the plugin, as shipped on the release you
  purchased, fails to install on a supported Moodle/PHP combination
  (per the README) and we cannot supply a working fix within 30 days,
  you may request a full refund regardless of the 14-day window.
- **What you keep after a refund.** Because the software is GPLv3, a
  refund does not — and cannot — revoke your rights to the source. You
  may continue to use, modify, and redistribute any copy you obtained.
  The refund cancels the Marketplace update channel, nothing more.
  Best-effort bug fixes stay available to anyone through the public
  channels in section 13 regardless.
- **How refunds are paid.** Refunds are issued to the original payment
  method via Marketplace's standard refund flow, or directly by
  EduCheckout where Marketplace cannot.

## 6. Term, withdrawal, and end-of-life

- These Terms apply from the moment of purchase and continue for as
  long as we publish the plugin on Marketplace.
- We may withdraw the plugin from sale at any time. If we do, we will:
  - publish a notice with at least **90 days' lead time** on the
    EduCheckout product page and in the plugin's admin settings page;
  - ship a final maintenance release;
  - leave the GitHub repository public and the final release
    downloadable indefinitely (subject to GitHub's continued operation).
- A withdrawal does not trigger an automatic refund of past purchases.
  The version you installed keeps working forever — only the update
  channel ends.

## 7. Consumer guarantees and limitation of liability

EduCheckout sells from Australia. Where you deal with us as a
"consumer" within the meaning of the Australian Consumer Law (ACL),
you have non-excludable statutory guarantees — for example, that the
goods/services are of acceptable quality and fit for any disclosed
purpose. **Nothing in these Terms excludes, restricts, or modifies any
right or remedy under the ACL or any equivalent non-excludable consumer
protection law in your jurisdiction.**

Subject to those non-excludable rights, and to the maximum extent
permitted by law:

- the software is provided **"as is"**, in line with the GPLv3 warranty
  disclaimer in sections 15–16 of the licence;
- our total aggregate liability arising out of or in connection with
  the Marketplace purchase is limited to the **total amount you
  actually paid us** for the plugin transaction from which the claim
  arose;
- we are not liable for indirect, consequential, special, or punitive
  damages, including loss of data, loss of revenue, downtime, or
  re-installation costs.

These limits apply to the **commercial transaction**. They do not, and
cannot, attach further restrictions to your GPLv3 rights in the
software itself.

## 8. Acceptable use

You may use the plugin for any purpose permitted by GPLv3 and by the
laws applying to your Moodle site. We do not impose field-of-use
restrictions and we do not differentiate between educational,
commercial, government, or personal deployments at the price point.

The plugin is the enrolment method that the
[EduCheckout storefront](https://github.com/verzog/moodle-local_educheckout)
uses to enrol learners into the courses they purchase. **You are
responsible** for:

- configuring enrolment durations, group assignment, and roles to suit
  your courses;
- the consequences of any manual or programmatic enrolment changes you
  make through it; and
- granting the `enrol/educheckout:config`, `enrol/educheckout:manage`,
  `enrol/educheckout:enrol`, and `enrol/educheckout:unenrol`
  capabilities only to trusted staff.

## 9. Privacy

The plugin does not store any end-user personal data of its own; it
relies on Moodle's core enrolment subsystem and is implemented as a
Moodle Privacy API `null_provider`. EduCheckout, as Merchant of Record
for your purchase of the plugin, processes the billing data Marketplace
forwards to us (name, billing address, email, order metadata) solely to
complete the sale, issue receipts, meet tax obligations, and provide
support. We do not on-sell it. See the EduCheckout privacy statement on
[educheckout.com](https://educheckout.com) for the full processing
notice.

## 10. Disputes

- Refund and billing disputes are handled directly between you and
  EduCheckout — **not** through Moodle HQ. Email the address on your
  receipt as the first step.
- Bug reports follow the channels in section 13; any fixes are
  best-effort and as-available.
- These Terms are governed by the laws of **New South Wales,
  Australia**, and the courts of New South Wales have non-exclusive
  jurisdiction. This does not deprive you of the protection of any
  mandatory consumer law of the jurisdiction in which you ordinarily
  reside.

## 11. Miscellaneous — severability

If any provision of these Terms is held to be invalid, unenforceable,
or in conflict with GPLv3 or any applicable mandatory law (including
the Australian Consumer Law and equivalent consumer-protection regimes
in your jurisdiction), that provision is severed to the minimum extent
necessary and the remaining provisions continue in full force and
effect. The GPLv3-prevails statement in the preamble is reaffirmed
here as a substantive term, not merely an interpretive aid.

## 12. Changes to these Terms

We may update these Terms for future purchases. The Terms that apply to
**your** purchase are the ones published in the repository at the
release tag you installed; later changes do not retroactively alter
your refund window or your GPLv3 rights.

## 13. Contact and support

- Product page and source: <https://github.com/verzog/moodle-enrol_educheckout>
- Bug reports (fixes are best-effort and as-available): the issue tracker at
  <https://github.com/verzog/moodle-enrol_educheckout/issues>
- Paid support (optional commercial service): see [SUPPORT.md](SUPPORT.md)
- Vendor: EduCheckout / Vernon Spain — <https://educheckout.com>
- Refunds and billing: the email address shown on your EduCheckout receipt

---

*EduCheckout enrolment is free software under GPLv3. These Terms govern
the optional convenience-and-goodwill transaction of purchasing it
through Moodle Marketplace; they do not, and cannot, take away the
rights GPLv3 grants you in the software.*
