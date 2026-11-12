import chalk from 'chalk';

export function registerInit(program, api) {
  program
    .command('init')
    .description('Ensure work dirs, catalogs, and resource tree exist')
    .action(() => {
      const message = api.init();
      console.log(chalk.green(message));
    });
}
