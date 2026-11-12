import chalk from 'chalk';

export function registerCatalog(program, api) {
  const catalog = program.command('catalog').description('AI-managed catalog upserts (never hand-edit catalogs)');

  catalog
    .command('sync')
    .description('Upsert type/plans/results catalog rows from on-disk files')
    .argument('<id>', 'Work item id (e.g. feature-001)')
    .option('--summary <text>', 'Override results-catalog Summary cell')
    .action((id, opts) => {
      const result = api.catalogSync(id, { summary: opts.summary });
      console.log(chalk.green(`Synced ${result.id}: ${result.touched.join(', ')}`));
    });

  catalog
    .command('status')
    .description('Patch brief status, then sync catalogs')
    .argument('<id>', 'Work item id')
    .argument('<status>', 'New status value')
    .option('--summary <text>', 'Optional results-catalog Summary')
    .action((id, status, opts) => {
      const result = api.catalogStatus(id, status, { summary: opts.summary });
      console.log(chalk.green(`Status → ${status}; synced ${result.id}: ${result.touched.join(', ')}`));
    });
}
