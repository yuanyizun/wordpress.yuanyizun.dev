import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';
import { BASE_URL } from './base-url.mjs';
import { ROUTES } from './routes.mjs';
import { VIEWPORTS } from './viewports.mjs';

const OUT_DIR = './layout-report';

function routeSlug(route) {
  if (route === '/') return 'home';
  return route.replace(/^\/|\/$/g, '').replaceAll('/', '_');
}

function escapeHtml(value) {
  return String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;');
}

fs.mkdirSync(OUT_DIR, { recursive: true });

const browser = await chromium.launch();
let html = `<html><body style="font-family:sans-serif;padding:20px;"><h1>Layout Audit</h1>`;

try {
  const page = await browser.newPage();

  for (const route of ROUTES) {
    const slug = routeSlug(route);

    for (const vp of VIEWPORTS) {
      const heading = `${route} (${vp.name} - ${vp.width}x${vp.height})`;
      html += `<h3>${escapeHtml(heading)}</h3>`;

      try {
        await page.setViewportSize({ width: vp.width, height: vp.height });
        const response = await page.goto(`${BASE_URL}${route}`, {
          waitUntil: 'networkidle',
          timeout: 30000,
        });
        const status = response ? response.status() : 0;
        if (!response || status >= 400) {
          throw new Error(`HTTP ${status || 'no response'}`);
        }

        const fileName = `${slug}-${vp.name}.png`;
        await page.screenshot({
          path: path.join(OUT_DIR, fileName),
          fullPage: true,
        });
        html += `<img src="./${fileName}" style="max-width:600px;border:1px solid #ccc;" alt="${escapeHtml(heading)}" />`;
      } catch (error) {
        html += `<p style="color:#a40000;">Error: ${escapeHtml(error.message)}</p>`;
      }

      html += '<hr/>';
    }
  }
} finally {
  html += '</body></html>';
  fs.writeFileSync(path.join(OUT_DIR, 'report.html'), html);
  await browser.close();
}

console.log(`Report saved to ${OUT_DIR}/report.html`);
