const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

const BASE_URL = 'http://127.0.0.1:8000';
const SCREENSHOTS_DIR = path.join(__dirname, '..', 'docs', 'screenshots');

const EMAIL = 'augusto@gmail.com';
const PASSWORD = '123456';

const VIEWPORT = { width: 1280, height: 800 };

async function run() {
  fs.mkdirSync(SCREENSHOTS_DIR, { recursive: true });

  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: VIEWPORT });
  const page = await context.newPage();

  // ── Telas públicas ──────────────────────────────────────────────────────────

  console.log('📸 01-home.png');
  await page.goto(`${BASE_URL}/`);
  await page.waitForLoadState('networkidle');
  await page.screenshot({ path: path.join(SCREENSHOTS_DIR, '01-home.png'), fullPage: false });

  console.log('📸 02-login.png');
  await page.goto(`${BASE_URL}/login`);
  await page.waitForLoadState('networkidle');
  await page.screenshot({ path: path.join(SCREENSHOTS_DIR, '02-login.png'), fullPage: false });

  console.log('📸 03-cadastro.png');
  await page.goto(`${BASE_URL}/cadastro`);
  await page.waitForLoadState('networkidle');
  await page.screenshot({ path: path.join(SCREENSHOTS_DIR, '03-cadastro.png'), fullPage: false });

  // ── Login ───────────────────────────────────────────────────────────────────

  console.log('🔑 Fazendo login...');
  await page.goto(`${BASE_URL}/login`);
  await page.waitForLoadState('networkidle');

  const emailInput = page.locator('input[name="email"], input[type="email"]').first();
  const passwordInput = page.locator('input[name="password"], input[type="password"]').first();
  const submitBtn = page.locator('button[type="submit"]').first();

  await emailInput.fill(EMAIL);
  await passwordInput.fill(PASSWORD);
  await submitBtn.click();
  await page.waitForURL(`${BASE_URL}/dashboard/habits`, { timeout: 10000 }).catch(async () => {
    // Fallback: talvez o redirect seja diferente
    await page.waitForLoadState('networkidle');
  });

  // Se o login falhou (ainda na página de login), criar conta nova
  if (page.url().includes('/login')) {
    console.log('⚠️  Login falhou, tentando cadastro...');
    await page.goto(`${BASE_URL}/cadastro`);
    await page.waitForLoadState('networkidle');
    const nomeInput = page.locator('input[name="name"]').first();
    await nomeInput.fill('Augusto Saboia');
    await page.locator('input[name="email"]').first().fill('teste_readme@gmail.com');
    await page.locator('input[name="password"]').first().fill('123456');
    const confirmInput = page.locator('input[name="password_confirmation"]').first();
    if (await confirmInput.count() > 0) await confirmInput.fill('123456');
    await page.locator('button[type="submit"]').first().click();
    await page.waitForLoadState('networkidle');
  }

  console.log(`✅ Autenticado. URL atual: ${page.url()}`);

  // Criar hábito de exemplo se necessário
  await page.goto(`${BASE_URL}/dashboard/habits`);
  await page.waitForLoadState('networkidle');
  const habitsVisible = await page.locator('input[type="checkbox"]').count();
  if (habitsVisible === 0) {
    console.log('📝 Criando hábitos de exemplo...');
    const habits = ['Ler 10 páginas', 'Meditar', 'Exercitar'];
    for (const habit of habits) {
      await page.goto(`${BASE_URL}/dashboard/habits/create`);
      await page.waitForLoadState('networkidle');
      await page.locator('input[name="name"]').fill(habit);
      await page.locator('button[type="submit"]').click();
      await page.waitForLoadState('networkidle');
    }
  }

  // ── Telas autenticadas ──────────────────────────────────────────────────────

  console.log('📸 04-dashboard.png');
  await page.goto(`${BASE_URL}/dashboard/habits`);
  await page.waitForLoadState('networkidle');
  await page.screenshot({ path: path.join(SCREENSHOTS_DIR, '04-dashboard.png'), fullPage: false });

  console.log('📸 05-criar-habito.png');
  await page.goto(`${BASE_URL}/dashboard/habits/create`);
  await page.waitForLoadState('networkidle');
  await page.screenshot({ path: path.join(SCREENSHOTS_DIR, '05-criar-habito.png'), fullPage: false });

  console.log('📸 06-configurar.png');
  await page.goto(`${BASE_URL}/dashboard/habits/configurar`);
  await page.waitForLoadState('networkidle');
  await page.screenshot({ path: path.join(SCREENSHOTS_DIR, '06-configurar.png'), fullPage: false });

  // Descobrir id do primeiro hábito para editar
  const editLink = page.locator('a[href*="/edit"]').first();
  let editHabitId = 1;
  if (await editLink.count() > 0) {
    const href = await editLink.getAttribute('href');
    const match = href && href.match(/\/(\d+)\/edit/);
    if (match) editHabitId = parseInt(match[1]);
  }

  console.log(`📸 07-editar-habito.png (id=${editHabitId})`);
  await page.goto(`${BASE_URL}/dashboard/habits/${editHabitId}/edit`);
  await page.waitForLoadState('networkidle');
  await page.screenshot({ path: path.join(SCREENSHOTS_DIR, '07-editar-habito.png'), fullPage: false });

  console.log('📸 08-historico.png');
  await page.goto(`${BASE_URL}/dashboard/habits/historico`);
  await page.waitForLoadState('networkidle');
  await page.screenshot({ path: path.join(SCREENSHOTS_DIR, '08-historico.png'), fullPage: false });

  await browser.close();
  console.log('\n✅ Todos os screenshots salvos em docs/screenshots/');
  const files = fs.readdirSync(SCREENSHOTS_DIR);
  files.forEach(f => {
    const stat = fs.statSync(path.join(SCREENSHOTS_DIR, f));
    console.log(`  ${f} (${Math.round(stat.size / 1024)} KB)`);
  });
}

run().catch(err => {
  console.error('❌ Erro:', err.message);
  process.exit(1);
});
