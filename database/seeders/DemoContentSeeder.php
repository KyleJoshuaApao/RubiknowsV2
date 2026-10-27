<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\GalleryMedia;
use App\Models\Job;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Support\PublicContentCache;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Sample content for previewing the website on a development machine.
 *
 * The projects, testimonials and clients here are illustrative only, so the
 * seeder refuses to run in production.
 *
 * Run with: php artisan db:seed --class=DemoContentSeeder
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command?->error('Sample content is for local previews only and was not added to the production database.');

            return;
        }

        $image = fn (string $name) => "/images/site/{$name}-1600.webp";

        DB::transaction(function () use ($image): void {
            // Public company details, only filled in where a value is missing.
            foreach ([
                'company_name' => 'RubiKnows',
                'contact_phone' => '0945 411 6141',
                'office_address' => 'Prk Mencidor, Magugpo West, Tagum City, Davao del Norte',
                'about_est_year' => '2020',
                'about_experience_years' => '5',
                'about_projects_count' => '100',
            ] as $key => $value) {
                Setting::firstOrCreate(['key' => $key], ['value' => $value]);
            }

            foreach ($this->services($image) as $service) {
                Service::updateOrCreate(['slug' => $service['slug']], $service);
            }

            foreach ([
                ['slug' => 'sample-two-storey-residence-visayan-village', 'title' => 'Two-storey residence, Visayan Village', 'category_id' => 'Residential', 'status' => 'Featured', 'year' => '2025', 'location' => 'Tagum City, Davao del Norte', 'client' => 'Private owner', 'duration' => '9 months', 'image_url' => $image('column-works'), 'latitude' => 7.4372, 'longitude' => 125.7965,
                    'description' => "A four-bedroom family home on a corner lot. We prepared the structural design and permit plans, then built the house from foundation to finishing.\n\n- Reinforced concrete frame designed for the site's soft soil\n- Roof framing and waterproofing detailed for heavy rain\n- Turned over with as-built plans and a maintenance guide"],
                ['slug' => 'sample-commercial-building-apokon', 'title' => 'Three-storey commercial building, Apokon', 'category_id' => 'Commercial', 'status' => 'Featured', 'year' => '2024', 'location' => 'Tagum City, Davao del Norte', 'client' => 'Local retail owner', 'duration' => '14 months', 'image_url' => $image('rebar-deck'), 'latitude' => 7.4583, 'longitude' => 125.8221,
                    'description' => "Ground-floor shops with offices above. The owner kept the existing shop trading while we built the new structure behind it, then connected the two in a single weekend."],
                ['slug' => 'sample-warehouse-panabo', 'title' => 'Warehouse and loading bay', 'category_id' => 'Industrial', 'status' => 'Completed', 'year' => '2024', 'location' => 'Panabo City, Davao del Norte', 'client' => 'Agricultural supplier', 'duration' => '7 months', 'image_url' => $image('building-frame'), 'latitude' => 7.3074, 'longitude' => 125.6838,
                    'description' => "A steel-framed warehouse with a raised concrete loading bay and a yard for delivery trucks. We managed the project and supervised the steel fabricator and electrical contractor."],
                ['slug' => 'sample-farm-to-market-road', 'title' => 'Farm-to-market road concreting', 'category_id' => 'Civil works', 'status' => 'Completed', 'year' => '2023', 'location' => 'New Corella, Davao del Norte', 'client' => 'Barangay local government', 'duration' => '5 months', 'image_url' => $image('earthworks'), 'latitude' => 7.5869, 'longitude' => 125.8233,
                    'description' => "1.2 kilometres of concrete road with side drainage and two box culverts, built so farmers can move produce through the rainy season."],
                ['slug' => 'sample-school-building-assessment', 'title' => 'Structural assessment of a school building', 'category_id' => 'Consultancy', 'status' => 'Completed', 'year' => '2023', 'location' => 'Carmen, Davao del Norte', 'client' => 'Private school', 'duration' => '3 weeks', 'image_url' => $image('inspection'), 'latitude' => 7.3600, 'longitude' => 125.7100,
                    'description' => "After visible cracking appeared following an earthquake, we inspected the building, tested the concrete and gave the school a report with repair priorities and costs."],
                ['slug' => 'sample-subdivision-site-development', 'title' => 'Residential subdivision site development', 'category_id' => 'Civil works', 'status' => 'Completed', 'year' => '2022', 'location' => 'Mati City, Davao Oriental', 'client' => 'Property developer', 'duration' => '10 months', 'image_url' => $image('site-team'), 'latitude' => 6.9551, 'longitude' => 126.2165,
                    'description' => "Clearing, cut and fill, roads and drainage for a 60-lot subdivision, prepared so house construction could start immediately."],
            ] as $project) {
                Project::updateOrCreate(['slug' => $project['slug']], $project);
            }

            foreach ([
                ['title' => 'Column reinforcement for a three-storey building', 'url' => $image('column-works'), 'category' => 'Construction'],
                ['title' => 'Slab reinforcement before concrete pouring', 'url' => $image('rebar-deck'), 'category' => 'Construction'],
                ['title' => 'Tower cranes on a building project', 'url' => $image('building-frame'), 'category' => 'Project management'],
                ['title' => 'Earthworks for a subdivision road', 'url' => $image('earthworks'), 'category' => 'Site development'],
                ['title' => 'Foundation layout check', 'url' => $image('site-team'), 'category' => 'Construction'],
                ['title' => 'Preparing permit drawings', 'url' => $image('drawing-plans'), 'category' => 'Design'],
            ] as $media) {
                GalleryMedia::updateOrCreate(['title' => $media['title']], [...$media, 'type' => 'Photo', 'thumbnail_url' => $media['url'], 'album_name' => 'Sample photos']);
            }

            foreach ([
                ['client_name' => 'Maria Santos', 'company' => 'Homeowner, Tagum City', 'role' => null, 'quote' => 'They explained every stage before it started and the house was finished close to the schedule they gave us. When something had to change, we heard it from the engineer first.'],
                ['client_name' => 'Ramon dela Cruz', 'company' => 'Retail business owner', 'role' => null, 'quote' => 'Our shop stayed open the whole time the new building went up. The site was tidy and safe, and the weekly photo updates meant I never had to chase anyone.'],
                ['client_name' => 'Engr. Liza Bautista', 'company' => 'Agricultural supplier', 'role' => 'Operations manager', 'quote' => 'Clear estimates, honest advice on where we could save, and a warehouse that was ready before our peak season.'],
            ] as $testimonial) {
                Testimonial::updateOrCreate(['client_name' => $testimonial['client_name']], [...$testimonial, 'is_published' => true]);
            }

            foreach ([
                ['name' => 'Davao del Norte Agri Supply', 'type' => 'Client'],
                ['name' => 'Apokon Commercial Center', 'type' => 'Client'],
                ['name' => 'Carmen Christian School', 'type' => 'Client'],
                ['name' => 'Northpoint Steel Fabricators', 'type' => 'Partner'],
            ] as $client) {
                Client::updateOrCreate(['name' => $client['name']], $client);
            }

            Job::updateOrCreate(['title' => 'Site Foreman'], [
                'type' => 'Full-time',
                'location' => 'Tagum City',
                'is_archived' => false,
                'description' => "We are looking for an experienced foreman to lead our crews on residential and commercial projects.\n\n- Organise daily work and materials on site\n- Check workmanship against the plans\n- Keep the site safe and tidy",
                'requirements' => "- At least five years of experience as a foreman or leadman\n- Able to read construction plans\n- Based in or willing to relocate to Tagum City",
            ]);
        });

        PublicContentCache::forgetSettings();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function services(callable $image): array
    {
        return [
            ['slug' => 'civil-structural-engineering', 'title' => 'Civil & Structural Engineering', 'category' => 'Engineering', 'is_featured' => true, 'image_url' => $image('rebar-deck'),
                'short_description' => 'Structural design, analysis and computations for houses, commercial buildings and institutional projects.',
                'content' => "Every building we work on starts with sound structural design. Our engineers study the loads, the soil and the site, then design the foundations, columns, beams, slabs and roof framing.\n\n- Structural plans and details for building permit applications\n- Structural computations and design analysis\n- Foundation recommendations\n- Bill of quantities and cost estimates"],
            ['slug' => 'general-construction', 'title' => 'General Construction', 'category' => 'Construction', 'is_featured' => true, 'image_url' => $image('column-works'),
                'short_description' => 'Houses, commercial buildings and extensions, built to the approved plans from foundation to finishing.',
                'content' => "We build to the approved plans with our own site team and subcontractors we know well.\n\n- New houses and apartment buildings\n- Commercial buildings, shops and warehouses\n- Extensions, additional floors and renovations"],
            ['slug' => 'construction-project-management', 'title' => 'Construction & Project Management', 'category' => 'Management', 'is_featured' => true, 'image_url' => $image('building-frame'),
                'short_description' => 'Planning, scheduling, cost control and site supervision that keep a project on track.',
                'content' => "For owners who want an experienced team looking after their project, we manage the work from mobilisation to turnover."],
            ['slug' => 'design-planning', 'title' => 'Design & Planning', 'category' => 'Design', 'is_featured' => true, 'image_url' => $image('drawing-plans'),
                'short_description' => 'Floor plans, 3D views and permit-ready plans that turn an idea into a buildable design.',
                'content' => "Good projects start with a design that fits the site, the budget and the way the space will be used."],
            ['slug' => 'site-development', 'title' => 'Site Development', 'category' => 'Civil works', 'is_featured' => false, 'image_url' => $image('earthworks'),
                'short_description' => 'Earthworks, drainage, access roads and site preparation, done right before building starts.',
                'content' => "A building is only as good as the ground it stands on. We prepare sites so construction can start on a firm, well-drained base."],
            ['slug' => 'technical-consultancy', 'title' => 'Technical Consultancy', 'category' => 'Advisory', 'is_featured' => false, 'image_url' => $image('inspection'),
                'short_description' => 'Independent assessments, inspections and advice for owners facing important building decisions.',
                'content' => "Sometimes you need a clear engineering opinion before you commit. We give owners practical, independent advice."],
        ];
    }
}
