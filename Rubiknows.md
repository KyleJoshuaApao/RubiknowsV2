RubikKnows Engineering & Construction — CMS Technical Specification
Goal
The RubiKnows website is not a static showcase. It is a Content Management System (CMS) where administrators can manage the entire website without editing code or redeploying the application.

---

1. Sitemap
   Public Website
   RubiKnows Corporation
   │
   ├── Home
   │ ├── Hero Banner
   │ ├── Company Introduction
   │ ├── Featured Services
   │ ├── Latest Projects
   │ ├── Company Statistics
   │ ├── Testimonials
   │ ├── Partners & Clients
   │ └── Call-to-Action
   │
   ├── About
   │ ├── Company Profile
   │ ├── Vision
   │ ├── Mission
   │ ├── Core Values
   │ ├── Company History
   │ ├── Leadership Team
   │ ├── Engineers & Staff
   │ ├── Licenses & Certifications
   │ └── Awards
   │
   ├── Services
   │ ├── Engineering
   │ ├── Construction
   │ ├── Repair & Maintenance
   │ ├── Consultancy & Processing
   │ ├── Trading & Supply
   │ └── Individual Service Pages
   │
   ├── Projects
   │ ├── Featured Projects
   │ ├── Latest Projects
   │ ├── Ongoing Projects
   │ ├── Upcoming Projects
   │ ├── Completed Projects
   │ ├── By Category
   │ └── Project Details
   │
   ├── Gallery
   │ ├── Photos
   │ ├── Videos
   │ ├── Before & After
   │ ├── Construction Progress
   │ └── Events
   │
   ├── Careers
   │ ├── Open Positions
   │ ├── Internship
   │ ├── Job Requirements
   │ ├── Apply Online
   │ └── Application Status
   │
   ├── Request a Quotation
   │ ├── Service Selection
   │ ├── Project Information
   │ ├── Budget Range
   │ ├── Timeline
   │ ├── Attach Drawings
   │ └── Submit Request
   │
   ├── Contact
   │ ├── Contact Form
   │ ├── Office Address
   │ ├── Interactive Map
   │ ├── Business Hours
   │ ├── Social Media
   │ └── Emergency Hotline
   │
   └── Client Portal (Future)
   ├── Login
   ├── Project Progress
   ├── Quotations
   ├── Contracts
   ├── Billing
   └── Documents
   Administrator Portal
   Admin Dashboard
   │
   ├── Dashboard
   │ ├── Analytics
   │ ├── Visitors
   │ ├── Quotations
   │ ├── Job Applications
   │ ├── Contact Messages
   │ ├── Notifications
   │ └── Recent Activity
   │
   ├── Website Content Management
   │ ├── Homepage
   │ ├── About Page
   │ ├── Services
   │ ├── Projects
   │ ├── Gallery
   │ ├── Careers
   │ ├── Contact
   │ ├── Footer
   │ └── Navigation Menu
   │
   ├── Project Management
   │ ├── Add Project
   │ ├── Edit Project
   │ ├── Delete Project
   │ ├── Featured
   │ ├── Latest
   │ ├── Ongoing
   │ ├── Upcoming
   │ ├── Completed
   │ ├── Categories
   │ └── Progress Updates
   │
   ├── Service Management
   │ ├── Add Service
   │ ├── Edit Service
   │ ├── Delete Service
   │ ├── Categories
   │ ├── Pricing (Optional)
   │ └── Featured Services
   │
   ├── Gallery Management
   │ ├── Upload Photos
   │ ├── Upload Videos
   │ ├── Albums
   │ ├── Categories
   │ ├── Before & After
   │ └── Delete Media
   │
   ├── Career Management
   │ ├── Add Job
   │ ├── Edit Job
   │ ├── Archive Job
   │ ├── Applicants
   │ ├── Resume Downloads
   │ └── Interview Status
   │
   ├── Quotation Management
   │ ├── Incoming Requests
   │ ├── View Details
   │ ├── Assign Engineer
   │ ├── Generate Quotation
   │ ├── Send Email
   │ └── Status Tracking
   │
   ├── Contact Management
   │ ├── Inbox
   │ ├── Reply
   │ ├── Archive
   │ └── Spam Filter
   │
   ├── Team Management
   │ ├── Engineers
   │ ├── Employees
   │ ├── Leadership
   │ └── Organization Chart
   │
   ├── Testimonials
   │ ├── Add
   │ ├── Edit
   │ ├── Delete
   │ └── Publish
   │
   ├── Clients
   │ ├── Client Logos
   │ ├── Partners
   │ ├── Sponsors
   │ └── Success Stories
   │
   ├── Website Settings
   │ ├── Company Information
   │ ├── Logo
   │ ├── Hero Banner
   │ ├── Theme Colors
   │ ├── SEO
   │ ├── Social Media
   │ ├── Contact Details
   │ ├── Office Locations
   │ └── Google Maps
   │
   ├── User Management
   │ ├── Super Admin
   │ ├── Administrator
   │ ├── HR
   │ ├── Engineer
   │ ├── Project Manager
   │ ├── Content Editor
   │ └── Permissions
   │
   ├── Reports
   │ ├── Website Analytics
   │ ├── Visitor Reports
   │ ├── Quotations
   │ ├── Applications
   │ ├── Projects
   │ └── Downloads
   │
   └── System
   ├── Backup
   ├── Restore
   ├── Audit Logs
   ├── Activity Logs
   ├── Database
   ├── Email Settings
   └── Security

---

2. CMS Features
   ✅ No-Code Content Management
   The administrator can update the website without modifying source code or redeploying.
   Add/Edit/Delete Services
   Add/Edit/Delete Projects
   Upload Images & Videos
   Create Pages
   Edit Hero Sections
   Change Company Information
   Update Contact Details
   Edit Navigation
   Manage Footer
   Change Colors & Branding
   SEO Management
   Dynamic Homepage Sections & Website Features
   Latest Projects
   Featured Projects
   Ongoing Projects
   Upcoming Projects
   Completed Projects
   Featured Services
   News & Announcements
   Company Events
   Careers
   Gallery
   Client Testimonials
   Partner Logos
   Statistics Counter
   Project Progress Timeline
   Search
   Filters
   Pagination
   User Submission Modules
   Contact Form:
   Name
   Email
   Phone
   Subject
   Message
   File Attachment
   Request for Quotation:
   Personal Information
   Company
   Service Needed
   Project Location
   Budget
   Timeline
   Project Description
   Upload Plans/Documents
   Submit
   Careers:
   Job Listings
   Apply Online
   Resume Upload
   Cover Letter
   Portfolio Upload
   Application Tracking

---

3. Design System
   Typography
   Role Font Weight Size Usage
   Display Roboto Slab 700 56px Hero headlines
   H1 Roboto Slab 700 40px Page titles
   H2 Roboto Slab 600 32px Section titles
   H3 Inter 600 24px Card titles
   Body Inter 400 16px Paragraphs, descriptions
   Small Inter 400 14px Captions, metadata
   Mono JetBrains Mono 400 13px Stats, codes, labels
   Color Tokens
   Managed dynamically via Admin Portal Website Settings (Theme Colors) and compiled/inlined into views. Default system fallbacks:
   Token Default Value Description
   `--background` `#ffffff` Clean white ground
   `--foreground` `#111111` Bold dark text
   `--card` `#f9f9f9` Light card surface
   `--card-foreground` `#111111` Card text
   `--primary` `#E07B2A` Brand orange
   `--primary-foreground` `#ffffff` Text on orange
   `--secondary` `#111111` Dark accent element
   `--secondary-foreground` `#ffffff` Text on dark element
   `--muted` `#f3f4f6` Muted backgrounds
   `--muted-foreground` `#4b5563` Muted text
   `--accent` `#E07B2A` Accent (same as primary)
   `--accent-foreground` `#ffffff` Text on accent
   `--border` `rgba(17,17,17,0.08)` Subtle border
   `--radius` `0.25rem` Sharp, precise corners
   Spacing
   Base unit: 4px
   Section padding: 96px vertical (desktop), 48px (mobile)
   Card padding: 32px
   Grid gaps: 24px
   Interaction Patterns
   Element Default Hover Transition
   Primary CTA Orange bg `#E07B2A` Darken 10% 200ms ease
   Ghost Button Dark border, transparent bg Fill dark 200ms ease
   Cards Flat `translateY(-4px)` + shadow 200ms ease
   Nav Links No underline Gold underline slides in from left 200ms ease
   Section Labels JetBrains Mono, uppercase, `letter-spacing: 3px`, muted gold — —
   Section Label Convention
   Every major section opens with a numbered mono label:

```
01 — OUR SERVICES
02 — FEATURED PROJECTS
03 — WHY CHOOSE US
```

---

4. Database Schema Specification
   To support the CMS, the following database tables are defined:
   Users & Authentication
   `users`: `id`, `name`, `email`, `password`, `role` (Super Admin, Administrator, HR, Engineer, Project Manager, Content Editor), `remember_token`, `created_at`, `updated_at`
   Content & Services
   `services`: `id`, `title`, `slug`, `icon` (SVG or class), `short_description`, `content` (HTML/Markdown), `category` (Engineering, Construction, Repair, Consultancy, Trading), `is_featured` (boolean), `price` (decimal, optional), `created_at`, `updated_at`
   `projects`: `id`, `title`, `slug`, `category_id`, `status` (Featured, Latest, Ongoing, Upcoming, Completed), `year`, `location`, `client`, `duration`, `value`, `description`, `highlights` (text/json), `image_url`, `tags` (text/json), `created_at`, `updated_at`
   `project_updates`: `id`, `project_id`, `update_title`, `description`, `progress_percentage`, `update_date`, `created_at`
   Media & Engagement
   `gallery_media`: `id`, `type` (Photo, Video), `title`, `url`, `thumbnail_url`, `album_name`, `category` (Before & After, Construction Progress, Events), `before_after_pair_id` (optional, for before & after slider), `created_at`
   `testimonials`: `id`, `client_name`, `company`, `role`, `quote`, `is_published` (boolean), `created_at`
   `clients`: `id`, `name`, `logo_url`, `type` (Partner, Client, Sponsor), `success_story_url` (optional)
   Human Resources & Submissions
   `jobs`: `id`, `title`, `type` (Full-time, Part-time, Contract, Internship), `location`, `requirements` (json/text), `description`, `is_archived` (boolean), `created_at`
   `job_applications`: `id`, `job_id`, `name`, `email`, `phone`, `cover_letter` (text), `resume_path`, `portfolio_path`, `status` (Received, Under Review, Interview Scheduled, Accepted, Rejected), `created_at`
   `contact_messages`: `id`, `name`, `company`, `email`, `phone`, `subject`, `message`, `attachment_path`, `status` (New, Read, Replied, Archived, Spam), `created_at`
   `quotation_requests`: `id`, `name`, `company`, `email`, `phone`, `service_needed`, `project_location`, `budget`, `timeline`, `description`, `attachment_path`, `assigned_engineer_id` (nullable foreign key to users), `status` (Pending, Under Review, Estimated, Sent, Closed), `created_at`
   Settings & Auditing
   `settings`: `id`, `key` (string, unique), `value` (text), `created_at`, `updated_at` (stores dynamic configs: logo, branding colors, Google Map code, office hours, SEO defaults, metadata)
   `audit_logs`: `id`, `user_id`, `action` (e.g. "Updated homepage hero banner"), `ip_address`, `user_agent`, `created_at`

---

5. Security & Access Control
    > [!IMPORTANT]
    > Since this application exposes administrative capabilities, security controls are paramount.
    > Role-Based Access Control (RBAC)
    > Super Admin: Full system access (System backup, restorations, user management, audit logs).
    > Administrator: Manage settings, website content, projects, services, and team.
    > HR: Manage careers, open positions, view applicants, and download resumes.
    > Engineer / Project Manager: View assigned quotations, update project progress, post project updates.
    > Content Editor: Create, edit, and delete services, projects, and gallery media.
    > Form & Input Protection
    > Sanitization: Strip HTML/script tags from admin inputs unless explicitly allowed (e.g., custom maps embed code or rich text editor fields which must be sanitized using HTML Purifier).
    > File Upload Validation: Enforce strict file size limits (resumes: 5MB, drawings: 20MB) and MIME-type restrictions (allow only PDF, DOCX for resumes; PDF, DWG, PNG, JPG for drawings/plans).
    > CSRF Protection: Laravel's `@csrf` middleware on all state-changing POST/PUT/DELETE forms.
    > Rate Limiting: Throttle public contact and quotation requests to prevent spam (max 3 submissions per IP per 10 minutes). Throttle admin login attempts.

---

6. Development Roadmap
   Phase 1 — Foundation & Authentication
   Configure Laravel environment, database connection, and setup Vite asset bundling.
   Set up authentication system (Admin Login, Password Reset).
   Create admin layout (responsive sidebar, user menu, alert system).
   Initialize base database migrations.
   Phase 2 — Database Schema & Core CMS Controllers
   Run migrations for Content models (Services, Projects, Gallery, Settings, Testimonials, Clients).
   Build the Admin CRUD pages for website content editing (Homepage sections, settings, custom styles).
   Implement file upload helpers with secure local/S3 storage.
   Phase 3 — Submission Modules & Management
   Run migrations for Careers (Jobs, Applications) and Contacts (Contact messages, Quotations).
   Develop the applicant tracking and quotation management screens in the Admin portal.
   Add email notification triggers for new submissions.
   Phase 4 — Public Website Integration
   Map routes to retrieve data dynamically from database.
   Convert homepage sections, about us, services list, project portfolio, and gallery to pull from DB.
   Apply Dynamic Settings (Branding colors, Logo, Social Media links) dynamically to the public layout.
   Phase 5 — Reports, System & Audit Hardening
   Implement Reports panel showing metrics (number of submissions, monthly applications, quotation breakdown).
   Set up system settings (DB backups, security parameters, audit logs tracker).
   Optimize database queries with indexes and implement view caching.

---

7. Implementation Notes (Laravel CMS)
   Backend Framework: Laravel 11 (PHP 8.2+) with Eloquent ORM.
   Frontend Templating: Blade Views using Tailwind CSS/Vanilla CSS and Vite.
   Interactivity: Alpine.js or Vanilla JavaScript for light components (carousel, mobile menu drawer, before/after slider).
   File Storage: `Storage` facade utilizing standard local disks, moving to AWS S3 / Cloudinary for production asset delivery.
   Page Rendering: High-speed server-side rendering (SSR) combined with query caching (`Cache::remember`) for high traffic sections.

---

8. Verification Checklist

# Check Criteria

1 CMS - General Admin can log in securely and see recent activity dashboard.
2 CMS - Content Adding, editing, or deleting a project/service immediately updates the public website.
3 CMS - Settings Changing branding colors in Settings updates the CSS variable tokens on public pages.
4 Security - Auth Guests cannot access any `/admin` route; role-based pages restrict unauthorized admin users.
5 Submissions Filling out Careers or Quotation form saves data to DB and displays in the admin panel.
6 File Uploads Uploading file formats other than permitted (e.g. .exe, .php) is rejected by validator.
7 SEO Meta tags for each page are dynamic and correspond to the SEO options defined in the CMS.
8 Performance Public pages load fast, leveraging query caching for services and projects lists.

---

2026 Enterprise Stack (Updated)
Frontend
React 19
Next.js 15
TypeScript
Tailwind CSS 4
shadcn/ui
Radix UI
Motion
TanStack Query
React Hook Form
Zod
Backend
Laravel 12
PHP 8.4
Laravel Octane
RoadRunner
Sanctum
Spatie Laravel Permission
Horizon
Pulse
Telescope
Infrastructure
MySQL 8.4
Redis
Meilisearch
Cloudinary (or AWS S3)
Docker
GitHub Actions
Vercel (Frontend)
Forge/VPS (Backend)
Sentry
Prometheus
Grafana
Uptime Kuma
Architecture

```text
Next.js Frontend
        │
 REST API (Laravel)
        │
Business Layer
        │
 MySQL + Redis + Storage
```

Recommended Improvements
Decouple frontend/backend using REST API.
Use Redis for cache, queues, and sessions.
Add Meilisearch for instant project and gallery search.
Replace simple role column with Spatie Permission.
Add 2FA, device sessions, email verification.
Use Cloudinary/S3 with WebP/AVIF optimization.
Add CI/CD using GitHub Actions.
Add monitoring and centralized logging.
Prepare APIs for future client portal and AI integrations.
