export function registerList(program, api) {
  program
    .command('list')
    .description('Dump catalogs (all brief types, or plans/results)')
    .argument('[type]', 'feature|fix|analysis|refactor|qa|plans|results|all', 'all')
    .action((type) => {
      const text = api.listText(type);
      process.stdout.write(text.endsWith('\n') ? text : `${text}\n`);
    });
}
