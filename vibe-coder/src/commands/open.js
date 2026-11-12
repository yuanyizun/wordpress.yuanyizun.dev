export function registerOpen(program, api) {
  program
    .command('open')
    .description('Print paths to open in Cursor')
    .argument('<id>', 'Work item id')
    .action((id) => {
      console.log(api.openText(id));
    });
}
