<?php

use App\Support\PublicContentCache;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Preview content so the live site can be reviewed fully filled in before real
 * projects are added. Rows are flagged is_preview and are only shown to
 * signed-in admins (see HasPreviewContent); visitors never see them.
 * Delete them from the admin panel once real content is in.
 */
return new class extends Migration
{
    private const TABLES = ['projects', 'gallery_media', 'news_posts'];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->boolean('is_preview')->default(false)->index();
            });
        }

        // Only the live site gets preview rows; development uses DemoContentSeeder.
        if (! app()->environment('production')) {
            return;
        }

        $image = fn (string $name) => "/images/site/{$name}-1600.webp";

        foreach ($this->projects($image) as $index => $project) {
            $date = now()->subDays(12 + $index * 23);

            DB::table('projects')->insert([
                ...$project,
                'slug' => Str::slug($project['title']).'-'.($index + 1),
                'is_preview' => true,
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            DB::table('gallery_media')->insert([
                'title' => $project['title'],
                'type' => 'Photo',
                'url' => $project['image_url'],
                'thumbnail_url' => $project['image_url'],
                'category' => $project['category_id'],
                'album_name' => 'Projects',
                'is_preview' => true,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        foreach ($this->news($image) as $index => $post) {
            DB::table('news_posts')->insert([
                ...$post,
                'facebook_url' => 'https://www.facebook.com/',
                'is_published' => true,
                'is_preview' => true,
                'created_at' => $post['posted_at'],
                'updated_at' => $post['posted_at'],
            ]);
        }

        PublicContentCache::forgetPublicContent();
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            DB::table($table)->where('is_preview', true)->delete();
            Schema::table($table, function (Blueprint $table): void {
                $table->dropColumn('is_preview');
            });
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function projects(callable $image): array
    {
        return [
            ['title' => 'Two-storey residence, Visayan Village', 'category_id' => 'Residential', 'status' => 'Featured', 'year' => '2025', 'location' => 'Tagum City, Davao del Norte', 'client' => 'Private owner', 'duration' => '9 months', 'image_url' => $image('column-works'), 'latitude' => 7.4372, 'longitude' => 125.7965,
                'description' => "A four-bedroom family home on a corner lot. We prepared the structural design and permit plans, then built the house from foundation to finishing.\n\n- Reinforced concrete frame designed for soft ground\n- Roof framing and waterproofing detailed for heavy rain\n- Turned over with as-built plans"],
            ['title' => 'Three-storey commercial building, Apokon', 'category_id' => 'Commercial', 'status' => 'Featured', 'year' => '2025', 'location' => 'Tagum City, Davao del Norte', 'client' => 'Retail business owner', 'duration' => '14 months', 'image_url' => $image('rebar-deck'), 'latitude' => 7.4583, 'longitude' => 125.8221,
                'description' => "Ground-floor shops with offices above. The owner kept the existing shop trading while the new structure went up behind it.\n\n- Structural design and building permit\n- Phased construction around a working shop\n- Roof deck ready for a future fourth floor"],
            ['title' => 'Warehouse and loading bay', 'category_id' => 'Industrial', 'status' => 'Featured', 'year' => '2024', 'location' => 'Panabo City, Davao del Norte', 'client' => 'Agricultural supplier', 'duration' => '7 months', 'image_url' => $image('building-frame'), 'latitude' => 7.3074, 'longitude' => 125.6838,
                'description' => 'A steel-framed warehouse with a raised concrete loading bay and a truck yard. We managed the project and supervised the steel fabricator and electrical contractor.'],
            ['title' => 'Farm-to-market road concreting', 'category_id' => 'Civil works', 'status' => 'Completed', 'year' => '2024', 'location' => 'New Corella, Davao del Norte', 'client' => 'Barangay local government', 'duration' => '5 months', 'image_url' => $image('earthworks'), 'latitude' => 7.5869, 'longitude' => 125.8233,
                'description' => '1.2 kilometres of concrete road with side drainage and two box culverts, so farmers can move produce through the rainy season.'],
            ['title' => 'Clinic renovation and extension', 'category_id' => 'Commercial', 'status' => 'Completed', 'year' => '2024', 'location' => 'Davao City', 'client' => 'Medical practice', 'duration' => '6 months', 'image_url' => $image('drawing-plans'), 'latitude' => 7.0731, 'longitude' => 125.6128,
                'description' => 'Design and construction of a rear extension with two consultation rooms, carried out while the clinic stayed open.'],
            ['title' => 'Structural assessment of a school building', 'category_id' => 'Consultancy', 'status' => 'Completed', 'year' => '2024', 'location' => 'Carmen, Davao del Norte', 'client' => 'Private school', 'duration' => '3 weeks', 'image_url' => $image('inspection'), 'latitude' => 7.3600, 'longitude' => 125.7100,
                'description' => 'After cracking appeared following an earthquake, we inspected the building, tested the concrete and reported repair priorities and costs.'],
            ['title' => 'Residential subdivision site development', 'category_id' => 'Civil works', 'status' => 'Completed', 'year' => '2023', 'location' => 'Mati City, Davao Oriental', 'client' => 'Property developer', 'duration' => '10 months', 'image_url' => $image('site-team'), 'latitude' => 6.9551, 'longitude' => 126.2165,
                'description' => 'Clearing, cut and fill, roads and drainage for a 60-lot subdivision, ready for house construction.'],
            ['title' => 'Two-storey shop and residence, Digos', 'category_id' => 'Commercial', 'status' => 'Completed', 'year' => '2023', 'location' => 'Digos City, Davao del Sur', 'client' => 'Family business', 'duration' => '11 months', 'image_url' => $image('rebar-deck'), 'latitude' => 6.7497, 'longitude' => 125.3572,
                'description' => 'A two-storey shop with the family residence above, on a narrow lot. Structural design and building permit handled by our team.'],
            ['title' => 'Slope protection and drainage, Nabunturan', 'category_id' => 'Civil works', 'status' => 'Completed', 'year' => '2023', 'location' => 'Nabunturan, Davao de Oro', 'client' => 'Private landowner', 'duration' => '4 months', 'image_url' => $image('earthworks'), 'latitude' => 7.6075, 'longitude' => 125.9656,
                'description' => 'Grouted riprap, a reinforced concrete retaining wall and lined canals to stop erosion along a hillside access road.'],
            ['title' => 'Fellowship hall, Santo Tomas', 'category_id' => 'Institutional', 'status' => 'Completed', 'year' => '2022', 'location' => 'Santo Tomas, Davao del Norte', 'client' => 'Church congregation', 'duration' => '8 months', 'image_url' => $image('column-works'), 'latitude' => 7.5292, 'longitude' => 125.6247,
                'description' => 'A column-free hall for 300 people with a long-span steel roof, built in phases as the congregation raised funds.'],
            ['title' => 'Beach resort cottages, Samal', 'category_id' => 'Residential', 'status' => 'Completed', 'year' => '2022', 'location' => 'Island Garden City of Samal, Davao del Norte', 'client' => 'Resort operator', 'duration' => '9 months', 'image_url' => $image('building-frame'), 'latitude' => 7.0735, 'longitude' => 125.7090,
                'description' => 'Eight guest cottages and a reception building, designed for coastal wind loads and salt-air durability.'],
            ['title' => 'Rice warehouse and drying area, Asuncion', 'category_id' => 'Industrial', 'status' => 'Completed', 'year' => '2021', 'location' => 'Asuncion, Davao del Norte', 'client' => 'Farmers cooperative', 'duration' => '6 months', 'image_url' => $image('site-team'), 'latitude' => 7.5389, 'longitude' => 125.7547,
                'description' => 'A warehouse for 5,000 sacks of palay and a 1,200 square metre concrete drying pavement with drainage.'],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function news(callable $image): array
    {
        return [
            ['title' => 'Roof slab poured at the Apokon commercial building', 'body' => 'Our team completed the third-floor roof slab this week, a day ahead of schedule. Curing continues while the masonry crew moves on to the second floor.', 'image_path' => $image('rebar-deck'), 'posted_at' => now()->subDays(2)->setTime(16, 30)],
            ['title' => 'Groundbreaking in Visayan Village', 'body' => 'We broke ground on a new two-storey family home in Tagum City. Site clearing and layout are done; excavation for the footings starts next week.', 'image_path' => $image('column-works'), 'posted_at' => now()->subDays(9)->setTime(9, 15)],
            ['title' => 'We are hiring a Project Engineer', 'body' => 'Join our Tagum City team. We are looking for a licensed civil engineer to run building and civil works projects across Davao del Norte.', 'image_path' => $image('site-team'), 'posted_at' => now()->subDays(16)->setTime(11, 0)],
            ['title' => 'Warehouse turned over in Panabo', 'body' => 'The steel-framed warehouse and loading bay for our client in Panabo City is complete and in use, ready for the harvest season.', 'image_path' => $image('building-frame'), 'posted_at' => now()->subDays(27)->setTime(14, 45)],
            ['title' => 'Road concreting finished in New Corella', 'body' => 'All 1.2 kilometres of the farm-to-market road are now concreted, with side drainage and two box culverts in place.', 'image_path' => $image('earthworks'), 'posted_at' => now()->subDays(41)->setTime(10, 20)],
        ];
    }
};
