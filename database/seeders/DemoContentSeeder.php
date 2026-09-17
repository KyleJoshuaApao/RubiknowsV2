<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\GalleryMedia;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Support\PublicContentCache;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoContentSeeder extends Seeder
{
    /**
     * Seed clearly labelled, repeatable demo content without deleting real CMS data.
     *
     * Run explicitly with: php artisan db:seed --class=DemoContentSeeder
     */
    public function run(): void
    {
        $photos = [
            'transit' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=1600&q=85',
            'tower' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=85',
            'bridge' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1600&q=85',
            'concrete' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1600&q=85',
            'interior' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1600&q=85',
            'facade' => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1600&q=85',
            'site' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=1600&q=85',
            'road' => 'https://images.unsplash.com/photo-1519501025264-65ba15a82390?auto=format&fit=crop&w=1600&q=85',
        ];

        DB::transaction(function () use ($photos): void {
            foreach ([
                [
                    'slug' => 'demo-bayline-transit-hub',
                    'title' => '[Demo] Bayline Transit Hub',
                    'category_id' => 'Infrastructure',
                    'status' => 'Featured',
                    'year' => '2025',
                    'location' => 'Cagayan de Oro City, Philippines',
                    'client' => 'Northline Development Group',
                    'duration' => '24 months',
                    'value' => '₱185M',
                    'description' => 'A resilient multimodal hub designed to make everyday movement safer, clearer, and more connected.',
                    'image_url' => $photos['transit'],
                    'latitude' => 8.4542,
                    'longitude' => 124.6319,
                ],
                [
                    'slug' => 'demo-golden-hour-tower',
                    'title' => '[Demo] Golden Hour Tower',
                    'category_id' => 'Structural Engineering',
                    'status' => 'Featured',
                    'year' => '2024',
                    'location' => 'Davao City, Philippines',
                    'client' => 'Aurelia Properties',
                    'duration' => '30 months',
                    'value' => '₱420M',
                    'description' => 'A high-performance mixed-use structure balancing a bold silhouette with efficient, durable systems.',
                    'image_url' => $photos['tower'],
                    'latitude' => 7.0731,
                    'longitude' => 125.6128,
                ],
                [
                    'slug' => 'demo-north-channel-bridge',
                    'title' => '[Demo] North Channel Bridge',
                    'category_id' => 'Civil Works',
                    'status' => 'Completed',
                    'year' => '2023',
                    'location' => 'Davao City, Philippines',
                    'client' => 'Pacific Corridor Authority',
                    'duration' => '18 months',
                    'value' => '₱96M',
                    'description' => 'A long-span crossing engineered for dependable daily service and demanding tropical conditions.',
                    'image_url' => $photos['bridge'],
                    'latitude' => 7.1907,
                    'longitude' => 125.4553,
                ],
                [
                    'slug' => 'demo-harbor-logistics-campus',
                    'title' => '[Demo] Harbor Logistics Campus',
                    'category_id' => 'Construction Management',
                    'status' => 'Completed',
                    'year' => '2022',
                    'location' => 'General Santos City, Philippines',
                    'client' => 'Harborlink Ventures',
                    'duration' => '20 months',
                    'value' => '₱255M',
                    'description' => 'A coordinated logistics campus built around efficient circulation, clear phasing, and long-term adaptability.',
                    'image_url' => $photos['concrete'],
                    'latitude' => 6.1164,
                    'longitude' => 125.1716,
                ],
                [
                    'slug' => 'demo-lumen-civic-center',
                    'title' => '[Demo] Lumen Civic Center',
                    'category_id' => 'Architecture',
                    'status' => 'Featured',
                    'year' => '2025',
                    'location' => 'Butuan City, Philippines',
                    'client' => 'Lumen Civic Foundation',
                    'duration' => '16 months',
                    'value' => '₱138M',
                    'description' => 'A flexible public venue that brings daylight, community, and practical civic operations together.',
                    'image_url' => $photos['interior'],
                    'latitude' => 8.9475,
                    'longitude' => 125.5406,
                ],
                [
                    'slug' => 'demo-highland-access-road',
                    'title' => '[Demo] Highland Access Road',
                    'category_id' => 'Project Management',
                    'status' => 'Completed',
                    'year' => '2021',
                    'location' => 'Malaybalay City, Philippines',
                    'client' => 'Summit Estates',
                    'duration' => '14 months',
                    'value' => '₱74M',
                    'description' => 'A carefully staged access improvement that strengthens safety and reliability across a steep terrain.',
                    'image_url' => $photos['road'],
                    'latitude' => 8.1575,
                    'longitude' => 125.1276,
                ],
            ] as $project) {
                Project::updateOrCreate(['slug' => $project['slug']], $project);
            }

            foreach ([
                ['slug' => 'demo-civil-structural-engineering', 'title' => '[Demo] Civil & Structural Engineering', 'category' => 'Engineering', 'short_description' => 'Clear, resilient engineering from concept through construction.', 'content' => 'We develop practical civil and structural solutions that keep ambitious projects safe, efficient, and built for the long term.', 'image_url' => $photos['bridge'], 'is_featured' => true],
                ['slug' => 'demo-construction-management', 'title' => '[Demo] Construction Management', 'category' => 'Delivery', 'short_description' => 'Disciplined coordination for complex project delivery.', 'content' => 'Our project teams align people, schedules, budgets, and quality so every phase moves with purpose.', 'image_url' => $photos['concrete'], 'is_featured' => true],
                ['slug' => 'demo-project-management', 'title' => '[Demo] Project Management', 'category' => 'Advisory', 'short_description' => 'Strategic oversight that turns plans into progress.', 'content' => 'From feasibility to handover, we create visibility and accountability across the full project lifecycle.', 'image_url' => $photos['site'], 'is_featured' => true],
                ['slug' => 'demo-architecture-design', 'title' => '[Demo] Architecture & Design', 'category' => 'Design', 'short_description' => 'Places that perform beautifully and endure.', 'content' => 'We shape thoughtful environments through a balance of context, materiality, function, and identity.', 'image_url' => $photos['facade'], 'is_featured' => true],
                ['slug' => 'demo-site-development', 'title' => '[Demo] Site Development', 'category' => 'Infrastructure', 'short_description' => 'Site systems designed for real-world conditions.', 'content' => 'Our site development work connects grading, drainage, access, and utilities into one coordinated outcome.', 'image_url' => $photos['road'], 'is_featured' => false],
                ['slug' => 'demo-technical-consultancy', 'title' => '[Demo] Technical Consultancy', 'category' => 'Advisory', 'short_description' => 'Experienced guidance for high-stakes decisions.', 'content' => 'We bring independent technical thinking to reviews, audits, value engineering, and delivery strategy.', 'image_url' => $photos['tower'], 'is_featured' => false],
            ] as $service) {
                Service::updateOrCreate(['slug' => $service['slug']], $service);
            }

            foreach ([
                ['title' => '[Demo] Foundations in motion', 'url' => $photos['site'], 'category' => 'On site', 'album_name' => 'Demo portfolio'],
                ['title' => '[Demo] Structure and light', 'url' => $photos['facade'], 'category' => 'Architecture', 'album_name' => 'Demo portfolio'],
                ['title' => '[Demo] Built for the crossing', 'url' => $photos['bridge'], 'category' => 'Infrastructure', 'album_name' => 'Demo portfolio'],
                ['title' => '[Demo] The work behind the work', 'url' => $photos['concrete'], 'category' => 'Construction', 'album_name' => 'Demo portfolio'],
                ['title' => '[Demo] A place to gather', 'url' => $photos['interior'], 'category' => 'Interiors', 'album_name' => 'Demo portfolio'],
                ['title' => '[Demo] City lines', 'url' => $photos['tower'], 'category' => 'Urban', 'album_name' => 'Demo portfolio'],
                ['title' => '[Demo] On the access road', 'url' => $photos['road'], 'category' => 'Civil works', 'album_name' => 'Demo portfolio'],
                ['title' => '[Demo] Site team', 'url' => $photos['transit'], 'category' => 'People', 'album_name' => 'Demo portfolio'],
            ] as $media) {
                GalleryMedia::updateOrCreate(['title' => $media['title']], array_merge($media, [
                    'type' => 'Photo',
                    'thumbnail_url' => $media['url'],
                ]));
            }

            foreach ([
                ['client_name' => 'Elena Ramos', 'company' => 'Northline Development Group', 'role' => 'Development Director', 'avatar_url' => $photos['interior'], 'quote' => 'RubiKnows gave our team clarity at every decision point. The result feels considered, resilient, and ready for the future.'],
                ['client_name' => 'Marcus Villanueva', 'company' => 'Pacific Corridor Authority', 'role' => 'Program Lead', 'avatar_url' => $photos['bridge'], 'quote' => 'Their engineering discipline made a complex infrastructure program feel coordinated from the first workshop to final handover.'],
                ['client_name' => 'Sofia Tan', 'company' => 'Aurelia Properties', 'role' => 'Project Executive', 'avatar_url' => $photos['tower'], 'quote' => 'The RubiKnows team combines technical depth with a genuine understanding of how people experience a place.'],
                ['client_name' => 'Adrian Cruz', 'company' => 'Harborlink Ventures', 'role' => 'Managing Partner', 'avatar_url' => $photos['site'], 'quote' => 'We always knew what was happening, why it mattered, and what decision came next. That level of trust is rare.'],
                ['client_name' => 'Mina Garcia', 'company' => 'Lumen Civic Foundation', 'role' => 'Board Trustee', 'avatar_url' => $photos['facade'], 'quote' => 'They translated an ambitious civic brief into a practical, welcoming project our community can be proud of.'],
            ] as $testimonial) {
                Testimonial::updateOrCreate(['client_name' => '[Demo] '.$testimonial['client_name']], array_merge($testimonial, [
                    'client_name' => '[Demo] '.$testimonial['client_name'],
                    'is_published' => true,
                ]));
            }

            foreach ([
                ['name' => '[Demo] Northline Development Group', 'type' => 'Client', 'logo_url' => 'https://placehold.co/640x320/E0A92A/0B0C0C.png?text=NORTHLINE'],
                ['name' => '[Demo] Aurelia Properties', 'type' => 'Client', 'logo_url' => 'https://placehold.co/640x320/0B0C0C/E0A92A.png?text=AURELIA'],
                ['name' => '[Demo] Pacific Corridor Authority', 'type' => 'Client', 'logo_url' => 'https://placehold.co/640x320/F4F4F4/0B0C0C.png?text=PACIFIC+CORRIDOR'],
                ['name' => '[Demo] Harborlink Ventures', 'type' => 'Partner', 'logo_url' => 'https://placehold.co/640x320/E0A92A/0B0C0C.png?text=HARBORLINK'],
                ['name' => '[Demo] Lumen Civic Foundation', 'type' => 'Partner', 'logo_url' => 'https://placehold.co/640x320/0B0C0C/FFFFFF.png?text=LUMEN+CIVIC'],
                ['name' => '[Demo] Summit Estates', 'type' => 'Client', 'logo_url' => 'https://placehold.co/640x320/F4F4F4/0B0C0C.png?text=SUMMIT+ESTATES'],
            ] as $client) {
                Client::updateOrCreate(['name' => $client['name']], $client);
            }
        });

        // The production app uses shared database-backed cache entries. Make
        // the newly seeded CMS records visible immediately after this command.
        PublicContentCache::forgetProjects();
        PublicContentCache::forgetHome();
    }
}
