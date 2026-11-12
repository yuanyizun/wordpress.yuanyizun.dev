---
id: feature-001
type: feature
status: done
title: Set up WordPress site for Still Cup
date: 2026-11-12
scope: full
---

# Set up WordPress site for Still Cup

## Instructions

Human: add requirements as bullet points below.

-

- Install a fresh WordPress site in the project root (wordpress.yuanyizun.dev) as the Still Cup staging foundation (analysis-001 step 2).
- Use MySQL: DB_HOST=localhost, DB_NAME=test (create if missing), DB_USER=dev, DB_PASSWORD=Wow2031010. If auth fails with user dev, try user test with the same password.
- Install WooCommerce and leave the site ready for theme/catalogue work; do not build the Still Cup theme in this feature.
- Document local URL, admin credentials (generated securely), and any setup commands in the results file. Do not commit secrets to git.
- Verify the site loads and wp-admin is reachable after install.

## Agent

- Follow `vibe-coder/rules/feature.md` (attach that file; do not paste it here)
