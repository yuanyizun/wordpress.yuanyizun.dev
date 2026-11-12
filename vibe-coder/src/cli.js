import { Command } from 'commander';
import chalk from 'chalk';
import { NotesError } from './lib/errors.js';
import { createBriefsApi } from './lib/briefs.js';
import { registerInit } from './commands/init.js';
import { registerNew } from './commands/new.js';
import { registerCatalog } from './commands/catalog.js';
import { registerDone } from './commands/done.js';
import { registerList } from './commands/list.js';
import { registerShow } from './commands/show.js';
import { registerOpen } from './commands/open.js';

const [major, minor] = process.versions.node.split('.').map(Number);
if (major < 20 || (major === 20 && minor < 12)) {
  console.error(
    chalk.red(
      `Error: Node.js 20.12+ is required (found ${process.version}). Install from https://nodejs.org`,
    ),
  );
  process.exit(1);
}

function canUseUi() {
  if (process.env.CI === 'true' || process.env.CI === '1') return false;
  return Boolean(process.stdout.isTTY && process.stdin.isTTY);
}

function fail(message) {
  console.error(chalk.red(`Error: ${message}`));
  process.exit(1);
}

const api = createBriefsApi();

const program = new Command();
program
  .name('vibe')
  .description('AI-driven vibe-coder workflow CLI')
  .version('1.0.0')
  .showHelpAfterError('(run vibe --help)');

registerInit(program, api);
registerNew(program, api);
registerCatalog(program, api);
registerDone(program, api);
registerList(program, api);
registerShow(program, api);
registerOpen(program, api);

program
  .command('menu')
  .description('Interactive Clack menu (TTY only)')
  .action(async () => {
    if (!canUseUi()) {
      program.help({ error: true });
      process.exit(1);
    }
    try {
      const { runMenu } = await import('./ui/menu.js');
      await runMenu(api);
    } catch (error) {
      if (error?.code === 'ERR_MODULE_NOT_FOUND') {
        fail('Dependencies are missing. Run npm install in the vibe-coder folder.');
      }
      throw error;
    }
  });

program.action(async () => {
  if (!canUseUi()) {
    program.help({ error: true });
    process.exit(1);
  }
  try {
    const { runMenu } = await import('./ui/menu.js');
    await runMenu(api);
  } catch (error) {
    if (error?.code === 'ERR_MODULE_NOT_FOUND') {
      fail('Dependencies are missing. Run npm install in the vibe-coder folder.');
    }
    throw error;
  }
});

async function main() {
  try {
    await program.parseAsync(process.argv);
  } catch (error) {
    if (error instanceof NotesError) fail(error.message);
    console.error(error);
    process.exit(1);
  }
}

main();
