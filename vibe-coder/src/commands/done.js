import chalk from 'chalk';

export function registerDone(program, api) {
  program
    .command('done')
    .description('Close-out: set status done, require results, sync catalogs')
    .argument('<id>', 'Work item id')
    .requiredOption('--summary <text>', 'One-line summary for results catalog')
    .action((id, opts) => {
      const result = api.done(id, { summary: opts.summary });
      console.log(chalk.green(`Done ${result.id}: ${result.touched.join(', ')}`));
    });
}
