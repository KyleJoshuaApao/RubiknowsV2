# Graph Report - Rubiknows  (2026-07-14)

## Corpus Check
- 305 files · ~161,756 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 716 nodes · 788 edges · 257 communities (253 shown, 4 thin omitted)
- Extraction: 99% EXTRACTED · 1% INFERRED · 0% AMBIGUOUS · INFERRED: 9 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- User
- Controller
- Model
- composer.json
- PublicController
- PublicController.php
- GalleryMedia
- LoginRequest
- devDependencies
- scripts
- Job
- Component
- QuotationRequest
- AppServiceProvider
- UserFactory
- DatabaseSeeder.php
- edit.blade.php
- packages.php
- services.php
- app.php
- Rubiknows.md

## God Nodes (most connected - your core abstractions)
1. `User` - 47 edges
2. `Controller` - 43 edges
3. `TestCase` - 20 edges
4. `PublicController` - 13 edges
5. `Job` - 13 edges
6. `Project` - 13 edges
7. `GalleryMedia` - 12 edges
8. `QuotationRequest` - 12 edges
9. `Service` - 12 edges
10. `Client` - 11 edges

## Surprising Connections (you probably didn't know these)
- `ClientController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/ClientController.php → app/Http/Controllers/Controller.php
- `ContactMessageController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/ContactMessageController.php → app/Http/Controllers/Controller.php
- `GalleryMediaController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/GalleryMediaController.php → app/Http/Controllers/Controller.php
- `JobApplicationController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/JobApplicationController.php → app/Http/Controllers/Controller.php
- `JobController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Admin/JobController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Communities (257 total, 4 thin omitted)

### Community 0 - "User"
Cohesion: 0.07
Nodes (30): ConfirmablePasswordController, RedirectResponse, Request, View, EmailVerificationNotificationController, RedirectResponse, Request, EmailVerificationPromptController (+22 more)

### Community 1 - "Controller"
Cohesion: 0.07
Nodes (18): User, Authenticatable, BaseTestCase, DatabaseSeeder, Notifiable, RefreshDatabase, Seeder, AuthenticationTest (+10 more)

### Community 2 - "Model"
Cohesion: 0.05
Nodes (41): pestphp/pest-plugin, php-http/discovery, autoload, autoload-dev, psr-4, psr-4, config, allow-plugins (+33 more)

### Community 3 - "composer.json"
Cohesion: 0.08
Nodes (11): Request, ProjectController, Request, SettingController, Request, PublicController, Project, Setting (+3 more)

### Community 4 - "PublicController"
Cohesion: 0.11
Nodes (11): AuthenticatedSessionController, RedirectResponse, Request, View, RedirectResponse, Request, View, ProfileController (+3 more)

### Community 5 - "PublicController.php"
Cohesion: 0.12
Nodes (12): NewContactMessageNotification, Content, Envelope, NewJobApplicationNotification, Content, Envelope, NewQuotationRequestNotification, Content (+4 more)

### Community 6 - "GalleryMedia"
Cohesion: 0.12
Nodes (7): ClientController, Request, Request, UserController, Client, FileUploadService, UploadedFile

### Community 7 - "LoginRequest"
Cohesion: 0.10
Nodes (11): ContactMessageController, Request, JobApplicationController, Request, Request, TestimonialController, ContactMessage, JobApplication (+3 more)

### Community 8 - "devDependencies"
Cohesion: 0.08
Nodes (25): alpinejs, autoprefixer, concurrently, laravel-vite-plugin, devDependencies, alpinejs, autoprefixer, concurrently (+17 more)

### Community 9 - "scripts"
Cohesion: 0.08
Nodes (26): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, pre-package-uninstall, setup (+18 more)

### Community 10 - "Job"
Cohesion: 0.33
Nodes (3): Request, QuotationRequestController, QuotationRequest

### Community 11 - "Component"
Cohesion: 0.23
Nodes (7): AppLayout, View, GuestLayout, View, View, PublicLayout, Component

### Community 12 - "QuotationRequest"
Cohesion: 0.31
Nodes (3): JobController, Request, Job

### Community 13 - "AppServiceProvider"
Cohesion: 0.27
Nodes (3): GalleryMediaController, Request, GalleryMedia

### Community 15 - "DatabaseSeeder.php"
Cohesion: 0.31
Nodes (3): Request, ServiceController, Service

### Community 16 - "edit.blade.php"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

### Community 34 - "packages.php"
Cohesion: 0.25
Nodes (7): About Laravel, Agentic Development, Code of Conduct, Contributing, Learning Laravel, License, Security Vulnerabilities

## Knowledge Gaps
- **73 isolated node(s):** `$schema`, `name`, `type`, `description`, `laravel` (+68 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **4 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `User` to `composer.json`, `PublicController`, `GalleryMedia`, `LoginRequest`, `Job`, `QuotationRequest`, `AppServiceProvider`, `DatabaseSeeder.php`?**
  _High betweenness centrality (0.095) - this node is a cross-community bridge._
- **Why does `User` connect `Controller` to `User`, `composer.json`, `PublicController`, `GalleryMedia`, `LoginRequest`, `Job`?**
  _High betweenness centrality (0.069) - this node is a cross-community bridge._
- **Why does `PublicController` connect `composer.json` to `User`, `AppServiceProvider`, `PublicController.php`, `DatabaseSeeder.php`?**
  _High betweenness centrality (0.018) - this node is a cross-community bridge._
- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _73 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `User` be split into smaller, more focused modules?**
  _Cohesion score 0.06636500754147813 - nodes in this community are weakly interconnected._
- **Should `Controller` be split into smaller, more focused modules?**
  _Cohesion score 0.06594071385359952 - nodes in this community are weakly interconnected._
- **Should `Model` be split into smaller, more focused modules?**
  _Cohesion score 0.047619047619047616 - nodes in this community are weakly interconnected._