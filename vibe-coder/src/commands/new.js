import chalk from 'chalk';
import { TYPES } from '../lib/constants.js';

export function registerNew(program, api) {
  program
    .command('new')
    .description('Create a human brief')
    .argument('<type>', `One of: ${TYPES.join(', ')}`)
    .argument('<title>', 'Short title or question')
    .option('--id <id>', 'ID as <prefix>-<number>')
    .option('--minor', 'Minor feature — no plan (feature only)')
    .option('--force', 'Overwrite existing brief')
    .option('--bullet <text>', 'Append an instruction bullet (repeatable)', collect, [])
    .action((type, title, opts) => {
      const result = api.createItem({
        type,
        title,
        id: opts.id,
        minor: Boolean(opts.minor),
        force: Boolean(opts.force),
        bullets: opts.bullet ?? [],
      });
      console.log(`\n${api.createdMessage(result)}`);
      console.log(chalk.green(`Catalog seeded for ${result.id}`));
    });
}

function collect(value, previous) {
  return previous.concat([value]);
}
