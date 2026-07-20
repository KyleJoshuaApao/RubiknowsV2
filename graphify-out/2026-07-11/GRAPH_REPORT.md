# Graph Report - .  (2026-07-11)

## Corpus Check
- cluster-only mode — file stats not available

## Summary
- 616 nodes · 725 edges · 187 communities (186 shown, 1 thin omitted)
- Extraction: 97% EXTRACTED · 3% INFERRED · 0% AMBIGUOUS · INFERRED: 25 edges (avg confidence: 0.8)
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

## God Nodes (most connected - your core abstractions)
1. `Controller` - 41 edges
2. `User` - 28 edges
3. `TestCase` - 20 edges
4. `PublicController` - 13 edges
5. `Job` - 13 edges
6. `GalleryMedia` - 12 edges
7. `Project` - 12 edges
8. `Client` - 11 edges
9. `JobApplication` - 11 edges
10. `QuotationRequest` - 11 edges

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

## Communities (187 total, 1 thin omitted)

### Community 0 - "User"
Cohesion: 0.07
Nodes (15): User, Authenticatable, BaseTestCase, Notifiable, RefreshDatabase, AuthenticationTest, EmailVerificationTest, PasswordConfirmationTest (+7 more)

### Community 1 - "Controller"
Cohesion: 0.07
Nodes (30): ConfirmablePasswordController, RedirectResponse, Request, View, EmailVerificationNotificationController, RedirectResponse, Request, EmailVerificationPromptController (+22 more)

### Community 2 - "Model"
Cohesion: 0.09
Nodes (14): ContactMessageController, Request, JobApplicationController, Request, Request, SettingController, Request, TestimonialController (+6 more)

### Community 3 - "composer.json"
Cohesion: 0.05
Nodes (41): pestphp/pest-plugin, php-http/discovery, autoload, autoload-dev, psr-4, psr-4, config, allow-plugins (+33 more)

### Community 4 - "PublicController"
Cohesion: 0.10
Nodes (8): Request, ProjectController, Request, ServiceController, Request, PublicController, Project, Service

### Community 5 - "PublicController.php"
Cohesion: 0.12
Nodes (12): NewContactMessageNotification, Content, Envelope, NewJobApplicationNotification, Content, Envelope, NewQuotationRequestNotification, Content (+4 more)

### Community 6 - "GalleryMedia"
Cohesion: 0.12
Nodes (8): ClientController, Request, GalleryMediaController, Request, Client, GalleryMedia, FileUploadService, UploadedFile

### Community 7 - "LoginRequest"
Cohesion: 0.11
Nodes (11): AuthenticatedSessionController, RedirectResponse, Request, View, RedirectResponse, Request, View, ProfileController (+3 more)

### Community 8 - "devDependencies"
Cohesion: 0.08
Nodes (25): alpinejs, autoprefixer, concurrently, laravel-vite-plugin, devDependencies, alpinejs, autoprefixer, concurrently (+17 more)

### Community 9 - "scripts"
Cohesion: 0.08
Nodes (26): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, pre-package-uninstall, setup (+18 more)

### Community 10 - "Job"
Cohesion: 0.24
Nodes (3): JobController, Request, Job

### Community 11 - "Component"
Cohesion: 0.23
Nodes (7): AppLayout, View, GuestLayout, View, View, PublicLayout, Component

### Community 12 - "QuotationRequest"
Cohesion: 0.33
Nodes (3): Request, QuotationRequestController, QuotationRequest

### Community 14 - "UserFactory"
Cohesion: 0.47
Nodes (3): UserFactory, Factory, static

### Community 15 - "DatabaseSeeder.php"
Cohesion: 0.60
Nodes (3): DatabaseSeeder, Seeder, WithoutModelEvents

### Community 16 - "edit.blade.php"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

## Knowledge Gaps
- **63 isolated node(s):** `$schema`, `name`, `type`, `description`, `laravel` (+58 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **1 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `Controller` to `Model`, `PublicController`, `GalleryMedia`, `LoginRequest`, `Job`, `QuotationRequest`?**
  _High betweenness centrality (0.115) - this node is a cross-community bridge._
- **Why does `User` connect `User` to `Controller`, `Model`, `QuotationRequest`, `DatabaseSeeder.php`?**
  _High betweenness centrality (0.037) - this node is a cross-community bridge._
- **Why does `PublicController` connect `PublicController` to `Controller`, `Job`, `PublicController.php`, `GalleryMedia`?**
  _High betweenness centrality (0.023) - this node is a cross-community bridge._
- **Are the 23 inferred relationships involving `User` (e.g. with `.index()` and `.show()`) actually correct?**
  _`User` has 23 INFERRED edges - model-reasoned connections that need verification._
- **What connects `$schema`, `name`, `type` to the rest of the system?**
  _63 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `User` be split into smaller, more focused modules?**
  _Cohesion score 0.07256894049346879 - nodes in this community are weakly interconnected._
- **Should `Controller` be split into smaller, more focused modules?**
  _Cohesion score 0.06636500754147813 - nodes in this community are weakly interconnected._