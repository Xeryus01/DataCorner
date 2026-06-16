# Datapedia

## Deployment folder structure

For shared hosting with separate application and public roots, use this layout:

- `~/sistem_app/datapedia` — application code and framework files
- `~/public_html/datapedia` — public web root for `index.php`, assets, and `.htaccess`

The project now includes a sample deployment entry point in `public_html/datapedia/index.php` that loads the app from `../../sistem_app/datapedia`.
