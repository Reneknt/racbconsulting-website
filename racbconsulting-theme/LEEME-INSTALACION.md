# RACBCONSULTING — Project Operating Guide

## Strategic Source of Truth

Before making changes, read:

`docs/RACBCONSULTING_MASTER_STRATEGIC_BLUEPRINT.md`

That file is the strategic source of truth for the current redesign.

This project is no longer an AI services agency website.

RACBCONSULTING is being rebuilt as an Executive Consulting Funnel.

---

## Core Positioning

RACBCONSULTING does not sell tools.
RACBCONSULTING does not sell automation.
RACBCONSULTING does not sell JSON.
RACBCONSULTING does not sell chatbots as the main offer.

RACBCONSULTING sells:

- executive judgment
- operational clarity
- structure
- authority
- results

Automation is only the implementation layer.

The real product is executive judgment.

---

## Current Website Purpose

`racbconsulting.com`

Purpose:

- Authority
- Executive diagnosis
- Premium consulting funnel

The homepage must sell Executive Consulting.

It must NOT be a generic catalog of AI services.

---

## Official Funnel

Main CTA:

`Book Executive Diagnostic`

Main CTA destination:

`https://mvp.racbconsulting.com`

Commercial flow:

Homepage
→ Executive Assessment
→ Results + Strategic Proposal Preview
→ Executive Review Session
→ Strategic Proposal
→ Implementation

No direct sales-call-first path.

Assessment first.

---

## Important Ecosystem Structure

`racbconsulting.com`

Executive Consulting Funnel.

`mvp.racbconsulting.com`

Executive Assessment, ECSOS, proposal engine, booking, internal consultant dashboard.

`flowforge.racbconsulting.com`

RACB FlowForge, workflow governance, workflow audit, production hardening, SaaS/product.

`agencies.racbconsulting.com`

AI Agency Operating System, Agency-in-a-Box.

`leasing.racbconsulting.com`

Vertical demos, proof environments.

`contractor.racbconsulting.com`

Contractor-focused sales funnel and contractor-specific assessment.

---

## Current Theme Structure

Expected structure:

```text
racbconsulting-theme/
├── style.css
├── functions.php
├── index.php
├── front-page.php
├── header.php
├── footer.php
├── assets/
│   ├── logo.png
│   └── racb-main.js
└── template-parts/
    └── legacy SPA files may exist from the old version