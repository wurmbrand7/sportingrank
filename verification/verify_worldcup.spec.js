import { test, expect } from '@playwright/test';

test('World Cup 2026 page renders correctly', async ({ page }) => {
  await page.goto('http://localhost:8000/worldcup.php');

  // Check hero section
  await expect(page.locator('h1')).toContainText('FootballWorld Cup 2026');

  // Check tabs
  const tabs = page.locator('.wc-tab-btn');
  await expect(tabs).toHaveCount(6);

  // Take screenshot of the initial view
  await page.screenshot({ path: '/home/jules/verification/worldcup_hero.png' });

  // Click on Stadiums tab and verify
  await page.click('text=Stadiums');
  await expect(page.locator('#tab-stadiums')).toBeVisible();
  await expect(page.locator('text=Host Stadiums')).toBeVisible();
  await page.screenshot({ path: '/home/jules/verification/worldcup_stadiums.png' });

  // Click on History tab and verify
  await page.click('text=Past Winners');
  await expect(page.locator('#tab-history')).toBeVisible();
  await expect(page.locator('text=Past Winners (1930 – 2022)')).toBeVisible();
  await page.screenshot({ path: '/home/jules/verification/worldcup_history.png' });
});
