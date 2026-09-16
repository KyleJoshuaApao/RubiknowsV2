<div align="center">
  <img src="public/RK3.png" alt="Rubiknows Logo" width="350"/>
  <h1>Rubiknows</h1>
</div>

## About Rubiknows

Rubiknows is a high-performance engineering design, analysis, and implementation platform across diverse sectors. It offers a comprehensive digital presence for engineering and construction portfolios, client management, job applications, and quotation systems.

## Features

- **Public Site**: Beautiful, responsive layout featuring projects, services, testimonials, and gallery.
- **Admin Dashboard**: Manage users, clients, testimonials, and job applications securely.
- **Auto CI/CD Ready**: Vercel configuration included.

## Tech Stack

- Laravel (PHP 8.2+)
- Alpine.js
- Tailwind CSS

## Render production configuration

New career application notifications use the Resend HTTPS API so they work on Render's free tier, where SMTP ports are unavailable. Configure these environment variables in Render before deploying:

- RESEND_API_KEY — a Resend API key with sending access.
- MAIL_FROM_ADDRESS — an address from a verified Resend domain.
- MAIL_FROM_NAME — the company sender name.

Set the company recipient in Admin → Settings → Contact Email. Each application is queued with retries and an idempotency key, and includes the uploaded resume and optional portfolio.

## License

This project is proprietary.
