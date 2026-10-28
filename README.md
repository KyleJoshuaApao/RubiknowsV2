# RubiKnows website

The website and content management system for RubiKnows, an engineering and construction company in Tagum City, Davao del Norte.

- **Public site:** services, projects (with a map of project locations), gallery, testimonials, clients, careers with online applications, and contact and quotation forms.
- **Admin panel** (sign in at the private path set by `ADMIN_LOGIN_PATH`, default `/staff-sign-in`): manage all of the above, read and reply to messages, quotation requests and job applications, and edit company details and the homepage.

Built with Laravel 13 (PHP 8.4), Alpine.js, Tailwind CSS for the admin panel and Vite. Production runs on Render with a Supabase Postgres database.

## Running it locally

Requirements: PHP 8.4 with the `pdo_sqlite`, `gd` and `intl` extensions, Composer, and Node 24.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

Create an admin account by setting `SUPER_ADMIN_EMAIL` and `SUPER_ADMIN_PASSWORD` in `.env`, then run:

```bash
php artisan db:seed
```

To preview the site with sample projects, testimonials and photos (local only, it refuses to run in production):

```bash
php artisan db:seed --class=DemoContentSeeder
```

Start the app and the asset server in two terminals:

```bash
php artisan serve
npm run dev
```

The site is then at <http://localhost:8000>. Run the tests with `php artisan test`.

## Production settings (Render)

The Docker image runs migrations on every start (`render-start.sh`), then starts Apache and a queue worker for outgoing email.

| Setting | Purpose |
| --- | --- |
| `APP_KEY`, `APP_URL`, `APP_ENV=production`, `APP_DEBUG=false` | Standard Laravel settings. |
| `DB_CONNECTION=pgsql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_SSLMODE=require` | Supabase Postgres. Use the **Session pooler** host and the `postgres.<project-ref>` username; Render cannot reach Supabase's IPv6-only direct host. |
| `RESEND_API_KEY`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` | Email notifications and replies. The from address must belong to a domain verified in Resend. Leave `MAIL_MAILER` unset (or set it to `resend`). |
| `SUPABASE_URL`, `SUPABASE_S3_ACCESS_KEY_ID`, `SUPABASE_S3_SECRET_ACCESS_KEY`, `SUPABASE_S3_REGION` | Permanent storage for uploads. Images go to the public `media` bucket; resumes and attachments go to the private `documents` bucket. Without these, uploads are lost whenever Render restarts the service. |
| `ADMIN_LOGIN_PATH` | Private address of the staff sign-in page, e.g. `office-7k2q`. It is never linked from the site, and signed-out visitors to admin pages see “page not found”. |
| `SUPER_ADMIN_EMAIL`, `SUPER_ADMIN_PASSWORD` | Optional. Used by `php artisan db:seed` to create the first admin. |

Notification emails go to the contact email set in **Admin → Settings**.

## Editing content

- Company details (phone, email, address, the About story and key figures) are in **Admin → Settings**.
- The homepage figures and careers text are in **Admin → Homepage editor**.
- In service, project and job descriptions, leave a blank line between paragraphs and start a line with a hyphen and a space for a bullet list.
- Sections of the site with no content (projects, gallery, testimonials, clients) are hidden from the navigation until something is published.

## License

Proprietary. All rights reserved.
