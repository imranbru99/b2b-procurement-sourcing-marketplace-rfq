<p align="center">
  <img src="docs/screenshots/dashboard.svg" alt="B2B Procurement Marketplace dashboard preview" width="100%"/>
</p>

<h1 align="center">B2B Procurement Marketplace</h1>

<p align="center"><strong>RFQ, bids and supplier discovery for B2B sourcing</strong></p>

<p align="center">
  <a href="https://github.com/imranbru99/b2b-procurement-sourcing-marketplace-rfq"><img alt="GitHub" src="https://img.shields.io/badge/GitHub-imranbru99%2Fb2b-procurement-sourcing-marketplace-rfq-0F172A?style=for-the-badge&logo=github"/></a>
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-PHP-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"/>
  <img alt="Author" src="https://img.shields.io/badge/Author-Imran%20Ahmed-14B8A6?style=for-the-badge"/>
</p>

---

## Overview

**B2B Procurement Marketplace** is a complete business application focused on real operational workflows. This README lists the full feature surface so GitHub visitors and search engines can understand every capability of the product.

## Product preview

| Dashboard | Operations |
| :---: | :---: |
| ![Dashboard](docs/screenshots/dashboard.svg) | ![Operations](docs/screenshots/operations.svg) |

## Complete feature list

### Application modules

- Contracts
- Core
- Intelligence
- Marketplace
- Operations
- Orders
- Platform
- Sourcing
- Suppliers

### Domain models

- Belongs To Organization
- Contact Message
- Module
- Organization
- Organization Module
- Organization User

### HTTP / API controllers

- Bid APIs & screens
- Blog APIs & screens
- Category APIs & screens
- Contact APIs & screens
- Demo Login APIs & screens
- Demo Request APIs & screens
- Home APIs & screens
- Locale APIs & screens
- Me APIs & screens
- Order APIs & screens
- Page APIs & screens
- Rfq Board APIs & screens
- Rfq APIs & screens
- Sitemap APIs & screens
- Supplier APIs & screens
- Supplier Directory APIs & screens

### Detailed feature requirements delivered

- Application name: **Procurement and Sourcing Marketplace (B2B)**
- Tagline: RFQ, bids, supplier discovery, in one platform.
- PHP 8.3+, Laravel (latest stable), Filament (latest stable, multiple panels), MySQL/MariaDB, Redis (queues, cache), Livewire, Tailwind CSS, Alpine.js.
- Public website: Blade + Tailwind + Alpine (fast, SEO friendly, responsive, dark/light).
- Queue workers, scheduler, Laravel Reverb or Pusher for real-time notifications, Laravel Sanctum for the API, Pest for tests.
- `modules` table (key, name, description, group, icon, dependencies, is_core, default_enabled, sort) and `organization_modules` (organization_id, module_key, enabled, settings JSON, enabled_at).
- Dependency handling: enabling a module auto-suggests or enables its dependencies; disabling is blocked, or warns, when others depend on it.
- Super Admin can toggle modules globally and per organization, assign modules to subscription plans, and view usage.
- Provide `Module::enabled('key')` helper, a Blade directive `@module('key')`, and a test suite proving every module can be turned off independently without errors.
- Panels: **Platform Admin**, **Buyer**, **Supplier**, **Logistics/Partner**, plus public site and API.
- Platform: Super Admin, Platform Manager, Support Agent, Finance Officer, Compliance/KYC Officer, Content Editor.
- Buyer org: Owner/Admin, Procurement Manager, Buyer/Sourcing Specialist, Requester/Department User, Approver, Finance/AP, Warehouse/Receiver, Auditor (read-only).
- Supplier org: Owner/Admin, Sales/Bid Manager, Catalog Manager, Finance/Billing, Logistics/Dispatch.
- Others: Logistics Partner, Third-Party Inspector, Guest (public), API Client.
- Purchase Requisitions: department requests, budget check, multi-level approval matrix (amount/category/department rules), delegation.
- Supplier Invitations and RFQ Broadcast: auto-match suppliers by category/location/certification/rating and notify them.
- Bidding / Quotations: supplier bid submission (price tiers, alternates, lead time, validity, attachments), sealed bids, drafts, revisions, bid withdrawal.
- Bid Comparison and Scoring: side-by-side matrix, weighted criteria (price, quality, delivery, compliance), evaluator panels with individual scoring, auto-ranking, total-cost-of-ownership calculator.
- Reverse Auctions: live English/Dutch/sealed auctions, bid decrements, auto-extend, real-time updates.
- Negotiation: counter-offers, messaging, history, approval before award.
- Award and Contracts: split awards, contract generation from templates (PDF), e-signature, clauses library, renewals and expiry alerts, contract repository.
- Purchase Orders: from award or direct, revisions, acknowledgment by supplier, blanket/call-off orders.
- Goods Receipt and Quality (GRN): partial receipts, QC inspection, returns/rejections, 3-way match (PO + GRN + invoice).
- Escrow and Wallet: milestone-based escrow, wallet top-up, payouts, commission and fee engine.
- Supplier Profiles and Storefronts: company page, capabilities, factories, certifications, portfolio, videos, downloads, public mini-site per supplier with custom slug.
- Product and Service Catalog: items, variants, price tiers, MOQ, bulk import (CSV/Excel), punch-out-ready, per-buyer special pricing, catalog-based direct ordering (no RFQ).
- Supplier Onboarding and KYC: multi-step registration, document upload, verification workflow, certificate expiry reminders, blacklisting/suspension, verification badges.
- Reviews and Ratings and Vendor Scorecards: post-order ratings, KPIs (on-time delivery, quality, response time, price competitiveness), performance trends.
- Risk and Compliance: risk scoring, sanctions/watchlist check hooks, ESG and diversity questionnaires, compliance document tracking, approved-vendor lists.
- Leads and Advertising: sponsored listings, featured suppliers, paid lead unlock, subscription plans for suppliers, coupons.
- Market Data and Catalog Scraper (laravel-ai-catalog): scheduled/queued scraping and import of products, prices and supplier data from online sources; price benchmarking against bids; admin review queue before publishing.
- Analytics and Reporting: spend analysis by category/supplier/department, savings tracking, cycle-time, supplier performance, bid-win rates, custom report builder, scheduled email reports, export CSV/Excel/PDF.
- Logistics and Shipment Tracking: shipment creation, carriers, tracking events, freight quotes (RFQ for freight), delivery proof, Incoterm-aware costs.
- Inspection and Site Attendance (laravel-attendance-hub): attendance-machine integration for receiving staff and inspectors, inspector assignments, supplier factory-audit check-in/check-out, audit checklists and reports.
- Budgets and Cost Centers: budgets per department/project, commitments vs actuals, alerts.
- Inventory-lite: stock levels for buyer, reorder points that auto-create requisitions.
- Disputes and Returns: dispute workflow, evidence, mediation by platform staff, resolution and refund.
- Messaging and Collaboration: threaded messages tied to RFQ/PO/contract, mentions, attachments, real-time chat, activity feed.
- Helpdesk: support tickets, SLA, knowledge base, live chat widget.
- CMS and Blog (laravel-universal-slug): pages, blog, FAQs, banners, SEO fields, multi-language content.
- Integrations and API: REST API (Sanctum) with OpenAPI docs, webhooks, ERP/accounting connectors (CSV/API-ready adapters for QuickBooks/Xero/Odoo style), Zapier-ready events.
- Subscriptions and Billing (platform): plans, trials, module-based pricing, invoices, dunning, usage limits.
- Multi-language PDF Documents (laravel-unicode-pdf): branded templates for every document, per-organization letterhead, QR code verification.
- Data Import/Export and Backup, Security Center (IP allow-list, session control, GDPR export/delete), Webhook and API logs.
- Demo credentials (password `password` or documented):
- Several demo organizations (e.g., a garment manufacturer buyer, a hospital buyer, a government buyer; 30+ suppliers across industries and countries) with DIFFERENT module sets enabled to prove modularity.
- Demo mode banner, auto-reset command (`demo:reset`) scheduled daily, and a "Login as" quick switcher on the demo page (enabled only when `APP_DEMO=true`).
- Security: OWASP top 10, policies on every model, rate limiting, CSRF, validated uploads with virus-scan hook, encrypted sensitive fields, tenant isolation tests.
- Performance: eager loading, indexes, caching via drutogoti, queues for heavy work, no N+1 (verify with a test/debug tool).
- UX: responsive, dark mode, RTL, keyboard friendly, empty states, loading states, helpful tooltips, onboarding tour, global search (Ctrl+K).
- i18n: English and Bangla fully translated at minimum, with the structure ready for more languages.
- DevOps: `.env.example` complete, Dockerfile and docker-compose, GitHub Actions CI, Supervisor/queue config, scheduler instructions, backup config.
- Read all package docs, scaffold Laravel + Filament, create README.md with the full feature list.
- Multi-tenancy, auth, roles/permissions, panels, Module Manager and its tests.
- Core modules (settings, notifications, audit, files, localization).
- Supplier modules (profiles, KYC, catalog, discovery, reviews).
- Sourcing modules (requisition, RFQ, bids, scoring, auctions, negotiation, award, contracts).
- Order-to-pay modules (PO, GRN, invoicing, payments, escrow, disputes, logistics, attendance).
- Intelligence modules (AI hub, catalog scraper, analytics).
- Platform modules (helpdesk, CMS, API, subscriptions, integrations, security).
- Public website, SEO, demo page.
- Seeders and demo data, full test run, performance and security pass, docs.
- Complete source code, migrations, seeders, factories, tests, Docker setup.
- `README.md` (features, screenshots list, install, demo logins, module guide, package usage), `docs/` with architecture, module development guide, API docs.

### Platform capabilities

- Multi-role ready structure for operators, managers and admins
- Database migrations and seeders for demo-ready local setup
- Laravel architecture with services/controllers/models separation
- Responsive UI foundation (Blade / Filament where enabled)
- Environment-based config for local and production databases
- GitHub-ready documentation with visual product previews

## Tech stack

- PHP 8.2+ / Laravel
- Filament admin resources (where enabled)
- Vite asset pipeline
- SQLite/MySQL-ready database layer
- Migrations, seeders, and test-ready structure

## Quick start

```bash
git clone https://github.com/imranbru99/b2b-procurement-sourcing-marketplace-rfq.git
cd b2b-procurement-sourcing-marketplace-rfq
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

## Repository

- GitHub: https://github.com/imranbru99/b2b-procurement-sourcing-marketplace-rfq
- Developer: **Imran Ahmed** · https://imrandev.bd

---

## 🤝 Let's Connect & Collaborate

I am open to **Senior Remote Full-Stack Roles**, AI Platform Architecture Contracts, and Enterprise Technical Advisory.

**Timezone:** UTC+6 (Dhaka / Rangpur, Bangladesh) — flexible overlap with US, UK & EU hours.  
**Delivery:** Async-ready · Slack · Discord · Jira · GitHub · production-first accountability.

| Channel | Handle | Link |
| :--- | :--- | :--- |
| Portfolio | imrandev.bd | https://imrandev.bd |
| Packagist | imrandevbd | https://packagist.org/packages/imrandevbd/ |
| LinkedIn | imranbru99 | https://linkedin.com/in/imranbru99 |
| GitHub | imranbru99 | https://github.com/imranbru99 |
| WhatsApp | +880 1576-918420 | https://wa.me/8801576918420 |
| Email | me@imrandev.bd | mailto:me@imrandev.bd |
| X | @imrandev_bd | https://x.com/imrandev_bd |
| YouTube | @ImranDevBD | https://youtube.com/@ImranDevBD |
