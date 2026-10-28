<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Support\PublicContentCache;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $sections = PublicContentCache::sections();

        $pages = collect([
            ['loc' => route('public.home'), 'priority' => '1.0'],
            ['loc' => route('public.services'), 'priority' => '0.9'],
            ['loc' => route('public.about'), 'priority' => '0.8'],
            ['loc' => route('public.contact'), 'priority' => '0.8'],
            ['loc' => route('public.careers'), 'priority' => '0.6'],
            $sections['projects'] ? ['loc' => route('public.projects'), 'priority' => '0.8'] : null,
            $sections['gallery'] ? ['loc' => route('public.gallery'), 'priority' => '0.5'] : null,
            $sections['testimonials'] ? ['loc' => route('public.testimonials'), 'priority' => '0.5'] : null,
            $sections['clients'] ? ['loc' => route('public.clients'), 'priority' => '0.5'] : null,
            ['loc' => route('public.privacy'), 'priority' => '0.2'],
            ['loc' => route('public.terms'), 'priority' => '0.2'],
        ])->filter();

        $services = Service::query()->get(['id', 'updated_at'])->map(fn (Service $service) => [
            'loc' => route('public.service-details', $service),
            'lastmod' => $service->updated_at?->toAtomString(),
            'priority' => '0.7',
        ]);

        $projects = Project::query()->get(['id', 'updated_at'])->map(fn (Project $project) => [
            'loc' => route('public.project-details', $project),
            'lastmod' => $project->updated_at?->toAtomString(),
            'priority' => '0.6',
        ]);

        return response()
            ->view('seo.sitemap', ['urls' => $pages->concat($services)->concat($projects)])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        // Private pages are kept out of search results with noindex headers rather
        // than listed here, so this file does not point anyone at them.
        $lines = [
            'User-agent: *',
            'Allow: /',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n")->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
