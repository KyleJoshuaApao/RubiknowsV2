<?php

use App\Support\PublicContentCache;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * One-off content cleanup before launch:
 * - removes the "[Demo]" placeholder projects, testimonials, clients and gallery
 *   items, and the "QWERTY" test service;
 * - unpublishes testimonials whose text is test input ("qwerty");
 * - rewrites the six placeholder services with the company's service copy;
 * - replaces the test text on the Project Engineer opening;
 * - deletes a leftover settings row that stored a secret for a removed feature;
 * - replaces the generic meta description the admin form used to pre-fill.
 *
 * Only rows matching the exact placeholder values are touched, so anything
 * already edited in the admin panel is left alone.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')->where('key', 'nvidia_nim_api_key')->delete();

        // The admin form used to pre-fill this generic line; replace it only if untouched.
        DB::table('settings')
            ->where('key', 'seo_description')
            ->where('value', 'Top-tier engineering, construction, and consultancy services.')
            ->update(['value' => 'RubiKnows is an engineering and construction company in Tagum City, Davao del Norte: structural design, building construction, site development and project management across Mindanao.']);

        DB::table('projects')->where('title', 'like', '[Demo]%')->delete();
        DB::table('testimonials')->where('client_name', 'like', '[Demo]%')->delete();
        DB::table('clients')->where('name', 'like', '[Demo]%')->delete();
        DB::table('gallery_media')->where('title', 'like', '[Demo]%')->delete();
        DB::table('services')->where('title', 'QWERTY')->delete();

        // Testimonials holding test text are hidden, not deleted, so the client
        // entry can be completed in the admin panel.
        DB::table('testimonials')->get(['id', 'quote'])
            ->filter(fn ($row) => preg_match('/^\W*(qwerty\W*)+$/i', trim((string) $row->quote)))
            ->each(fn ($row) => DB::table('testimonials')->where('id', $row->id)->update(['is_published' => false, 'updated_at' => now()]));

        foreach ($this->services() as $placeholderTitle => $service) {
            DB::table('services')
                ->where('title', $placeholderTitle)
                ->update([...$service, 'updated_at' => now()]);
        }

        DB::table('career_jobs')
            ->where('title', 'Project Engineer')
            ->whereRaw('lower(trim(description)) = ?', ['qwerty'])
            ->update([
                'description' => $this->projectEngineerDescription(),
                'requirements' => json_encode($this->projectEngineerRequirements()),
                'updated_at' => now(),
            ]);

        Cache::forget(PublicContentCache::SITE_SETTINGS);
        PublicContentCache::forgetPublicContent();
    }

    public function down(): void
    {
        // Placeholder content is not restored.
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function services(): array
    {
        return [
            '[Demo] Civil & Structural Engineering' => [
                'title' => 'Civil & Structural Engineering',
                'slug' => 'civil-structural-engineering',
                'category' => 'Engineering',
                'is_featured' => true,
                'image_url' => '/images/site/rebar-deck-1600.webp',
                'short_description' => 'Structural design, analysis and computations for houses, commercial buildings and institutional projects.',
                'content' => <<<'TEXT'
Every building we work on starts with sound structural design. Our engineers study the loads, the soil and the site, then design the foundations, columns, beams, slabs and roof framing for the way the building will actually be used.

We prepare the documents you need for your permit and for construction:

- Structural plans and details for building permit applications
- Structural computations and design analysis
- Foundation recommendations based on the site and available soil data
- Reinforced concrete and steel design for new buildings and extensions
- Bill of quantities and cost estimates

We also check existing buildings before renovations, additional floors or a change of use, so owners know what the structure can safely carry.
TEXT,
            ],
            '[Demo] Construction Management' => [
                'title' => 'General Construction',
                'slug' => 'general-construction',
                'category' => 'Construction',
                'is_featured' => true,
                'image_url' => '/images/site/column-works-1600.webp',
                'short_description' => 'Houses, commercial buildings and extensions, built to the approved plans from foundation to finishing.',
                'content' => <<<'TEXT'
We build to the approved plans with our own site team and subcontractors we know well, and we keep owners informed at every stage.

Our construction work covers:

- New houses and apartment buildings
- Commercial buildings, shops and warehouses
- Extensions, additional floors and renovations
- Concrete, masonry, roofing and finishing works
- Coordination of electrical, plumbing and other trades

Before work starts you receive a clear scope, a cost breakdown and a schedule. During construction our engineers supervise the work on site, and we walk you through the finished building before turnover.
TEXT,
            ],
            '[Demo] Project Management' => [
                'title' => 'Construction & Project Management',
                'slug' => 'construction-project-management',
                'category' => 'Management',
                'is_featured' => true,
                'image_url' => '/images/site/building-frame-1600.webp',
                'short_description' => 'Planning, scheduling, cost control and site supervision that keep a project on track.',
                'content' => <<<'TEXT'
For owners who want an experienced team looking after their project, we manage the work from mobilisation to turnover.

- Project planning, scheduling and progress monitoring
- Cost estimates, budget tracking and review of contractor billings
- Site supervision and quality checks against the approved plans
- Coordination between the owner, designers, contractors and suppliers
- Regular progress reports with site photos

The goal is simple: fewer surprises, decisions made on time, and a finished project that matches what was agreed.
TEXT,
            ],
            '[Demo] Architecture & Design' => [
                'title' => 'Design & Planning',
                'slug' => 'design-planning',
                'category' => 'Design',
                'is_featured' => true,
                'image_url' => '/images/site/drawing-plans-1600.webp',
                'short_description' => 'Floor plans, 3D views and permit-ready plans that turn an idea into a buildable design.',
                'content' => <<<'TEXT'
Good projects start with a design that fits the site, the budget and the way the space will be used. We work through it with you before anything is built.

- Site assessment and space planning
- Floor plans, elevations and 3D views
- Coordinated architectural, structural, electrical and plumbing plans
- Plans and documents for building permit applications
- Revisions as your requirements develop

Because our designers work alongside our engineers and builders, every plan is checked for cost and buildability from the start.
TEXT,
            ],
            '[Demo] Site Development' => [
                'title' => 'Site Development',
                'slug' => 'site-development',
                'category' => 'Civil works',
                'is_featured' => false,
                'image_url' => '/images/site/earthworks-1600.webp',
                'short_description' => 'Earthworks, drainage, access roads and site preparation, done right before building starts.',
                'content' => <<<'TEXT'
A building is only as good as the ground it stands on. We prepare sites so construction can start on a firm, well-drained base.

- Site clearing, excavation, cut and fill
- Grading and compaction
- Drainage, culverts and canals
- Access roads, driveways and concrete pavement
- Retaining walls, slope protection and perimeter fences

We plan earthworks around the soil and the rainy months, so the site stays workable while the building goes up.
TEXT,
            ],
            '[Demo] Technical Consultancy' => [
                'title' => 'Technical Consultancy',
                'slug' => 'technical-consultancy',
                'category' => 'Advisory',
                'is_featured' => false,
                'image_url' => '/images/site/inspection-1600.webp',
                'short_description' => 'Independent assessments, inspections and advice for owners facing important building decisions.',
                'content' => <<<'TEXT'
Sometimes you need a clear engineering opinion before you commit. We give owners practical, independent advice.

- Structural assessment of existing buildings
- Inspection after earthquakes, flooding or visible cracking
- Review of plans, estimates and contractor proposals
- Value engineering to reduce cost without reducing quality
- Technical reports for banks, insurers or permit requirements

You receive a written report in plain language, with recommendations you can act on.
TEXT,
            ],
        ];
    }

    private function projectEngineerDescription(): string
    {
        return <<<'TEXT'
We are looking for a Project Engineer to run construction projects out of our Tagum City office. You will work with the owners, the site team and our clients to deliver projects on time, within budget and to the approved plans.

**What you will do**

- Plan and schedule site activities and track progress against the schedule
- Supervise construction and check the quality of work against the plans and specifications
- Prepare quantity take-offs, cost estimates and progress billings
- Coordinate subcontractors, suppliers and the owner's representatives
- Keep site records, daily reports and safety documents up to date
TEXT;
    }

    private function projectEngineerRequirements(): string
    {
        return <<<'TEXT'
- Licensed Civil Engineer (PRC)
- At least two years of experience on building or civil works projects
- Working knowledge of AutoCAD and Excel; structural software is an advantage
- Able to read and interpret architectural and structural plans
- Willing to work on project sites in Davao del Norte and nearby provinces
TEXT;
    }
};
