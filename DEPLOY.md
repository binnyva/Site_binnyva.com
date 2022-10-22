# Deploy Site to binnyva.com

## Prework

- Make all the changes
- Test using command `npx eleventy --serve`
- Commit all the changes

## Deploy

- Build the site using `npx eleventy`
- This will write all the content to the `_site` folder.
- Deploy using this command...
`rsync -ravzhe ssh --progress "/mnt/x/Data/www/Sites/binnyva/binnyva.com/_site/" binnyva.com@binnyva.com:/home/binnyva.com/public_html`
