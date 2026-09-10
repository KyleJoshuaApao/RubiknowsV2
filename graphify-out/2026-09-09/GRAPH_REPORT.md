# Graph Report - RubiknowsV2  (2026-09-09)

## Corpus Check
- 295 files · ~1,403,787 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 1350 nodes · 1534 edges · 249 communities (207 shown, 42 thin omitted)
- Extraction: 99% EXTRACTED · 1% INFERRED · 0% AMBIGUOUS · INFERRED: 20 edges (avg confidence: 0.68)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `803f37f1`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

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
- 0001_01_01_000000_create_users_table.php
- 0001_01_01_000001_create_cache_table.php
- 0001_01_01_000002_create_jobs_table.php
- artisan
- app.php
- packages.php
- services.php
- app.php
- database.php
- filesystems.php
- queue.php
- session.php
- postcss.config.js
- index.php
- app.js
- index.blade.php
- create.blade.php
- auth-session-status.blade.php
- danger-button.blade.php
- dropdown-link.blade.php
- input-error.blade.php
- input-label.blade.php
- nav-link.blade.php
- responsive-nav-link.blade.php
- secondary-button.blade.php
- text-input.blade.php
- new.blade.php
- new.blade.php
- app.blade.php
- home.blade.php
- project-details.blade.php
- projects.blade.php
- table.blade.php
- button.blade.php
- footer.blade.php
- header.blade.php
- layout.blade.php
- message.blade.php
- panel.blade.php
- subcopy.blade.php
- table.blade.php
- 03844ba5f9f4671609d11de33b05119a.php
- 09358739ff2bccb398282abb4db16750.php
- 0cc96ad43133cc5a34fc4bb87c40d7e2.php
- 13d264671a6db1189085c584cd00d878.php
- 23be2217ce976a071cf2e8dd0ecb6778.php
- 2675973df398fcb0482d3fbc6e5d3789.php
- 2ee547e5b84a0e439851a96d25de552e.php
- 3112a9c89878a589eaa36c050a4103c2.php
- 7d71237272b782198f1b03d6fae3529b.php
- 7deea77351f6dc19d6a32c90ed8d8752.php
- 7df7ef33ece97729cc0fb5f73adf7f96.php
- 7e477fe3862c2f1f152b6bec580bd024.php
- 83b008f7cdda92b06caf4b2574986a6f.php
- 881b0224b4c7a0146771878ff900492a.php
- 8b06040ff579be6c50b945dcc93c3b89.php
- 8d6254b6aa2bda8afd2068bad1e075bf.php
- 90d0cc7e9a63be8c0b352dd64073ff82.php
- 926b870a85b65ada946a60e8b23a53ee.php
- 92972507b9ba21ac46e5544fb23e1340.php
- 98563da052594d2377741ac63d5476a9.php
- 9ec86e4dbfda7fd68c1b67b2ce95e210.php
- a0cfc4c7b29daf6b0c40c806e0f6f38c.php
- a7d0f0bf0a8368d8f477dc5b06e8daa6.php
- a981de94b5d7f91e9dafcff7a4994af4.php
- ab2ebd0f412130e104c75a5606c291f7.php
- ad367c13df1f1eb2f2c2c6ba53685219.php
- b73d24ecd81228b28066c6e77ea3419d.php
- bd5539d48cf90997304a3454261d421d.php
- c06add52375f1f9aed561c82ada0d49e.php
- c32431551f27305d54f89442604d5875.php
- c56af0a780bac4c61bdc505150427295.php
- d34bf0a5c903124ea8391f1b455a4bcd.php
- d45264c43d4b29edf0ab34022c354f0b.php
- d6bc283bfe0972eb085ee92c45d42596.php
- d9dc60aaaa171298f731ab05e11da157.php
- dc76257b5f2ac747e3552570485f0622.php
- df8f23c6f219dcaa8770156907092246.php
- e4075f685357f1142b9609f352a34782.php
- e452fe262f2af2725d191bd445c0d96c.php
- e4d52fc7bf7f7bd7e79137aa7ee89610.php
- e8744e36832a999651e8f516e84571e4.php
- f1928c22f90d5040077486c80d9a8111.php
- f400dac5d9b237af65b8ce4cf489c0fe.php

## God Nodes (most connected - your core abstractions)
1. `User` - 47 edges
2. `Controller` - 45 edges
3. `TestCase` - 20 edges
4. `handleCommand()` - 17 edges
5. `PublicController` - 15 edges
6. `Project` - 15 edges
7. `getActiveTab()` - 15 edges
8. `ContactMessage` - 13 edges
9. `Job` - 13 edges
10. `QuotationRequest` - 13 edges

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

## Communities (249 total, 42 thin omitted)

### Community 0 - "User"
Cohesion: 0.05
Nodes (19): AuthenticatedSessionController, ConfirmablePasswordController, EmailVerificationNotificationController, EmailVerificationPromptController, NewPasswordController, PasswordController, PasswordResetLinkController, RegisteredUserController (+11 more)

### Community 1 - "Controller"
Cohesion: 0.05
Nodes (40): 1. Think Before Coding, 2. Preserve Existing Architecture, 3. Follow Existing Patterns, 4. Produce Production Code, AI Development, API Standards, Architecture Guidelines, Autonomous Behavior (+32 more)

### Community 2 - "Model"
Cohesion: 0.05
Nodes (41): pestphp/pest-plugin, php-http/discovery, autoload, autoload-dev, psr-4, psr-4, config, allow-plugins (+33 more)

### Community 3 - "composer.json"
Cohesion: 0.06
Nodes (11): Request, ProjectController, PublicController, Client, Project, ClientController, GalleryMediaController, TestimonialController (+3 more)

### Community 4 - "PublicController"
Cohesion: 0.05
Nodes (39): 10. Responsive Behavior, 11. Technical Notes, 1. Brand Philosophy, 2. Color Palette, 3. Typography, 4. Layout & Spacing, 5. Component Architecture, 6. Visual Depth & Engineering Aesthetic (+31 more)

### Community 5 - "PublicController.php"
Cohesion: 0.10
Nodes (16): AdminReplyNotification, Content, Envelope, NewContactMessageNotification, Content, Envelope, NewJobApplicationNotification, Content (+8 more)

### Community 6 - "GalleryMedia"
Cohesion: 0.05
Nodes (21): Request, UserController, FileUploadService, Authenticatable, BaseTestCase, User, DatabaseSeeder, AuthenticationTest (+13 more)

### Community 7 - "LoginRequest"
Cohesion: 0.06
Nodes (18): ContactMessageController, Request, JobApplicationController, Request, LiveEditorController, Request, Request, QuotationRequestController (+10 more)

### Community 8 - "devDependencies"
Cohesion: 0.06
Nodes (33): alpinejs, @alpinejs/intersect, autoprefixer, concurrently, laravel-vite-plugin, dependencies, @alpinejs/intersect, @vercel/analytics (+25 more)

### Community 9 - "scripts"
Cohesion: 0.08
Nodes (26): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, pre-package-uninstall, setup (+18 more)

### Community 10 - "Job"
Cohesion: 0.06
Nodes (30): Before exploring, read these, Domain Docs, File structure, Flag ADR conflicts, Use the glossary's vocabulary, Conventions, Issue tracker: GitHub, Pull requests as a triage surface (+22 more)

### Community 11 - "Component"
Cohesion: 0.06
Nodes (34): activeTab, alarms, <all_urls>, debugger, scripting, storage, tabs, action (+26 more)

### Community 12 - "QuotationRequest"
Cohesion: 0.06
Nodes (29): Bad agent brief, Behavioral, not procedural, Complete acceptance criteria, Durability over precision, Examples, Explicit scope boundaries, Good agent brief (bug), Good agent brief (enhancement) (+21 more)

### Community 13 - "AppServiceProvider"
Cohesion: 0.07
Nodes (25): Learning Record Format, Numbering, Optional sections, Supersession, Template, What does _not_ qualify, When to write a learning record, MISSION.md Format (+17 more)

### Community 15 - "DatabaseSeeder.php"
Cohesion: 0.07
Nodes (25): 1. State the question, 2. Isolate the logic in a portable module, 3. Build the shareable HTML file, 4. Hand it over, 5. Capture the answer and the prototype, Anti-patterns, Logic Prototype, Process (+17 more)

### Community 16 - "edit.blade.php"
Cohesion: 0.50
Nodes (3): profile.partials.delete-user-form, profile.partials.update-password-form, profile.partials.update-profile-information-form

### Community 17 - "0001_01_01_000000_create_users_table.php"
Cohesion: 0.20
Nodes (25): attachedTabs, cmdClick(), cmdEmulateDevice(), cmdEmulateNetwork(), cmdGetConsoleErrors(), cmdGetElement(), cmdGetNetworkRequests(), cmdGetPageContent() (+17 more)

### Community 18 - "0001_01_01_000001_create_cache_table.php"
Cohesion: 0.09
Nodes (21): 1. In-process, 2. Local-substitutable, 3. Remote but owned (Ports & Adapters), 4. True external (Mock), Deepening, Dependency categories, Seam discipline, Testing strategy: replace, don't layer (+13 more)

### Community 19 - "0001_01_01_000002_create_jobs_table.php"
Cohesion: 0.09
Nodes (19): ADR Format, Numbering, Optional sections, Template, What qualifies, When to offer an ADR, CONTEXT.md Format, Rules (+11 more)

### Community 32 - "artisan"
Cohesion: 0.10
Nodes (18): Call-graph collapse, Candidate card, Cross-section (good for layered shallowness), Diagram patterns, Hand-built boxes-and-arrows (when Mermaid's layout fights you), Header, HTML Report Format, Mass diagram (good for "interface as wide as implementation") (+10 more)

### Community 33 - "app.php"
Cohesion: 0.14
Nodes (5): ServiceController, Service, UserFactory, Factory, static

### Community 34 - "packages.php"
Cohesion: 0.40
Nodes (4): About Rubiknows, Features, License, Tech Stack

### Community 38 - "database.php"
Cohesion: 0.22
Nodes (16): ask(), ask_secret(), banner(), _clear(), finish(), note(), open_url(), pause() (+8 more)

### Community 39 - "filesystems.php"
Cohesion: 0.14
Nodes (14): quickErrors(), quickNavigate(), quickNetwork(), quickReadPage(), quickScreenshot(), resultBox, resultContent, resultTitle (+6 more)

### Community 41 - "queue.php"
Cohesion: 0.12
Nodes (14): Phase boundaries, Primary and secondary sources, The five options, The tree, These are judgement calls, Ask Matt, Codebase health, Context hygiene (+6 more)

### Community 43 - "session.php"
Cohesion: 0.13
Nodes (14): Completion criterion: a tight loop that goes red, Diagnosing Bugs, Minimise, Non-deterministic bugs, Phase 1: Build a feedback loop, Phase 2: Reproduce + minimise, Phase 3: Hypothesise, Phase 4: Instrument (+6 more)

### Community 44 - "postcss.config.js"
Cohesion: 0.15
Nodes (12): 1. Detect package manager, 2. Install dependencies, 3. Initialize Husky, 4. Create `.husky/pre-commit`, 5. Create `.lintstagedrc`, 6. Create `.prettierrc` (if missing), 7. Verify, 8. Commit (+4 more)

### Community 45 - "index.php"
Cohesion: 0.15
Nodes (10): Designing for Mockability, When to Mock, Anti-patterns, Rules of the loop, Seams: where tests go, Test-Driven Development, What a good test is, Bad Tests (+2 more)

### Community 46 - "app.js"
Cohesion: 0.15
Nodes (12): 1. Gather context, 2. Explore the codebase (optional), 3. Draft vertical slices, 4. Quiz the user, 5. Publish the tickets to the configured tracker, Acceptance criteria, Blocked by, <NN>: <Ticket title> (+4 more)

### Community 47 - "index.blade.php"
Cohesion: 0.15
Nodes (11): Context pointers, Information hierarchy, Leading words, Invocation, Router skills, Skill mechanics, Splitting by invocation, Pruning (+3 more)

### Community 49 - "create.blade.php"
Cohesion: 0.31
Nodes (4): BaseHTTPRequestHandler, BridgeHandler, get_allowed_origins(), main()

### Community 79 - "auth-session-status.blade.php"
Cohesion: 0.22
Nodes (9): AntigravityBridge, main(), Bucle principal: leer mensajes de la extensión y procesarlos., Procesa un mensaje recibido de la extensión., Lee un mensaje del protocolo Native Messaging desde stdin., Envía un mensaje al protocolo Native Messaging hacia stdout., Gestiona la comunicación bidireccional entre:       - La extensión de Edge (via, read_native_message() (+1 more)

### Community 80 - "danger-button.blade.php"
Cohesion: 0.15
Nodes (12): 1. Basic Control, 2. Device Emulation (Responsive Design), 3. Network Throttling (Connection Simulation), 4. DOM Interactions, Antigravity Edge Bridge v2.1 (HTTP Polling), 🤖 Auto-Integration for Antigravity IDE (Zero Config), 🛠️ CLI Command Reference (`bridge_cli.py`), ⏱️ Installation Roadmap (Time to Install: ~3 Minutes) (+4 more)

### Community 82 - "dropdown-link.blade.php"
Cohesion: 0.17
Nodes (11): 1. Detect the environment, 2. Install dependency-cruiser, 3. Write the config, 4. Wire it into the checks, 5. Scaffold the example package, 6. Prove the rules bite, 7. Document the convention, Notes (+3 more)

### Community 83 - "input-error.blade.php"
Cohesion: 0.17
Nodes (11): Chart the map, Fog of war, Invocation, Out of scope, Plan, don't do, Refer by name, The Map, The map body (+3 more)

### Community 84 - "input-label.blade.php"
Cohesion: 0.42
Nodes (11): cmd_click(), cmd_content(), cmd_element(), cmd_emulate(), cmd_navigate(), cmd_network(), cmd_screenshot(), cmd_status() (+3 more)

### Community 86 - "nav-link.blade.php"
Cohesion: 0.17
Nodes (11): builds, env, APP_DEBUG, APP_ENV, CACHE_STORE, FILESYSTEM_DISK, QUEUE_CONNECTION, SESSION_DRIVER (+3 more)

### Community 88 - "responsive-nav-link.blade.php"
Cohesion: 0.20
Nodes (9): `as Type` → `fromPartial()`, `as unknown as Type` → `fromAny()`, Install, Large objects with few needed properties, Migrate to Shoehorn, Migration patterns, When to use each, Why shoehorn? (+1 more)

### Community 89 - "secondary-button.blade.php"
Cohesion: 0.22
Nodes (8): 1. Ask scope, 2. Copy the hook script, 3. Add hook to settings, 4. Ask about customization, 5. Verify, Setup Git Guardrails, Steps, What Gets Blocked

### Community 90 - "text-input.blade.php"
Cohesion: 0.22
Nodes (8): Directory naming, Example: stubbing from a plan, Exercise variants, Lint rules summary, Moving/renaming exercises, Required files, Scaffold Exercises, Workflow

### Community 92 - "new.blade.php"
Cohesion: 0.22
Nodes (8): Further Notes, Implementation Decisions, Out of Scope, Problem Statement, Process, Solution, Testing Decisions, User Stories

### Community 93 - "new.blade.php"
Cohesion: 0.25
Nodes (7): 1. Pin the fixed point, 2. Identify the spec source, 3. Identify the standards sources, 4. Spawn both sub-agents in parallel, 5. Aggregate, Process, Why two axes

### Community 95 - "app.blade.php"
Cohesion: 0.25
Nodes (7): Anything else?, Context, Document structure, How to answer, <Questionnaire title>, <Theme heading>, What load is the system expected to handle at launch?

### Community 106 - "home.blade.php"
Cohesion: 0.25
Nodes (7): Conversational feel, Format arguments to actually have, Grounding, Out of scope, Pulling from the pile, The loop, Writing rhythm

### Community 107 - "project-details.blade.php"
Cohesion: 0.36
Nodes (7): clean_dist(), main(), package_extension(), package_full_release(), Elimina la carpeta dist si ya existe para generar un paquete limpio., Comprime la carpeta de la extensión en un archivo ZIP listo para la tienda., Crea una carpeta de release estructurada con el servidor local y documentación.

### Community 108 - "projects.blade.php"
Cohesion: 0.29
Nodes (6): 1. Scope the procedure, 2. Map each stage's journey, 3. Author the wizard, 4. Verify and hand off, Process, Wizard

### Community 117 - "table.blade.php"
Cohesion: 0.29
Nodes (6): Conventions, Issue tracker: GitHub, Pull requests as a triage surface, Wayfinding operations, When a skill says "fetch the relevant ticket", When a skill says "publish to the issue tracker"

### Community 118 - "button.blade.php"
Cohesion: 0.33
Nodes (5): Ending the journey, Grounding, Pulling from the pile, What is a beat, Writing rhythm

### Community 119 - "footer.blade.php"
Cohesion: 0.53
Nodes (4): CheckSuperAdmin, Closure, Request, Response

### Community 120 - "header.blade.php"
Cohesion: 0.53
Nodes (4): Closure, Request, Response, SecurityHeaders

### Community 121 - "layout.blade.php"
Cohesion: 0.33
Nodes (5): Before exploring, read these, Domain Docs, File structure, Flag ADR conflicts, Use the glossary's vocabulary

### Community 122 - "message.blade.php"
Cohesion: 0.33
Nodes (5): 1. 100% Offline and Local Processing, 2. Browser Permissions Disclosures, 3. Security Recommendations, 4. Contact and Contributions, Privacy Policy for Antigravity Edge Bridge

### Community 123 - "panel.blade.php"
Cohesion: 0.40
Nodes (4): Agent skills, Domain docs, Issue tracker, Triage labels

### Community 124 - "subcopy.blade.php"
Cohesion: 0.40
Nodes (4): Definition of done, The loop lens, The workspace, Vocabulary

### Community 125 - "table.blade.php"
Cohesion: 0.40
Nodes (4): Files, Implementation vs Review, Reference, Steps

### Community 126 - "03844ba5f9f4671609d11de33b05119a.php"
Cohesion: 0.83
Nodes (3): capture(), hitl-loop.template.sh script, step()

### Community 127 - "09358739ff2bccb398282abb4db16750.php"
Cohesion: 0.50
Nodes (3): GLOSSARY.md Format, Rules, Structure

### Community 128 - "0cc96ad43133cc5a34fc4bb87c40d7e2.php"
Cohesion: 0.50
Nodes (3): File format, What is a fragment, Writing rhythm

### Community 129 - "13d264671a6db1189085c584cd00d878.php"
Cohesion: 0.50
Nodes (3): Antigravity Edge Bridge Integration, How to use the Edge Bridge:, Regla Obligatoria: Permiso para Navegador Real (Live Browser)

## Knowledge Gaps
- **488 isolated node(s):** `block-dangerous-git.sh script`, `$schema`, `name`, `type`, `description` (+483 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **42 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `Controller` connect `User` to `app.php`, `composer.json`, `GalleryMedia`, `LoginRequest`?**
  _High betweenness centrality (0.027) - this node is a cross-community bridge._
- **Why does `User` connect `GalleryMedia` to `User`, `app.php`, `LoginRequest`?**
  _High betweenness centrality (0.022) - this node is a cross-community bridge._
- **Why does `JobApplication` connect `LoginRequest` to `PublicController.php`?**
  _High betweenness centrality (0.005) - this node is a cross-community bridge._
- **What connects `block-dangerous-git.sh script`, `$schema`, `name` to the rest of the system?**
  _496 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `User` be split into smaller, more focused modules?**
  _Cohesion score 0.050595238095238096 - nodes in this community are weakly interconnected._
- **Should `Controller` be split into smaller, more focused modules?**
  _Cohesion score 0.04878048780487805 - nodes in this community are weakly interconnected._
- **Should `Model` be split into smaller, more focused modules?**
  _Cohesion score 0.047619047619047616 - nodes in this community are weakly interconnected._