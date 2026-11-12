export function registerShow(program, api) {
  program
    .command('show')
    .description('Print paths and summary for an id')
    .argument('<id>', 'Work item id')
    .action((id) => {
      console.log(api.showText(id));
    });
}
