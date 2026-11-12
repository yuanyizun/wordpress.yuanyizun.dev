---
id: feature-005
type: feature
status: done
title: Add Playwright script and report generator
date: 2026-11-12
scope: full
---

# Add Playwright script and report generator

## Instructions

Human: add requirements as bullet points below.

- create a playwright script to test the website, create new folder under root
- sample script:
```javascript
import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';

const BASE_URL = 'https://wordpress.yuanyizun.dev';
const ROUTES = ['/', '/about', '/contact'];
const VIEWPORTS = [
  { name: 'desktop', width: 1440, height: 900 },
  { name: 'mobile', width: 375, height: 812 },
];
const OUT_DIR = './layout-report';

fs.mkdirSync(OUT_DIR, { recursive: true });

const browser = await chromium.launch();
const page = await browser.newPage();
let html = `<html><body style="font-family:sans-serif;padding:20px;"><h1>Layout Audit</h1>`;

for (const route of ROUTES) {
  const slug = route === '/' ? 'home' : route.replace(/\//g, '_');
  for (const vp of VIEWPORTS) {
    await page.setViewportSize({ width: vp.width, height: vp.height });
    await page.goto(`${BASE_URL}${route}`, { waitUntil: 'networkidle' });

    const fileName = `${slug}-${vp.name}.png`;
    await page.screenshot({ path: path.join(OUT_DIR, fileName), fullPage: true });

    html += `<h3>${route} (${vp.name} - ${vp.width}x${vp.height})</h3>
             <img src="./${fileName}" style="max-width:600px;border:1px solid #ccc;" /><hr/>`;
  }
}

html += `</body></html>`;
fs.writeFileSync(path.join(OUT_DIR, 'report.html'), html);
await browser.close();
console.log(`Report saved to ${OUT_DIR}/report.html`);

```
- the variable need add to seprated files, such as base_url, routes and viewports
- we need to run the script by running `node audit.mjs`

## Agent

- Follow `vibe-coder/rules/feature.md` (attach that file; do not paste it here)
