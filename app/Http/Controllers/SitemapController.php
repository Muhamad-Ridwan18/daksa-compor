<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Service;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    /**
     * Generate robots.txt.
     */
    public function robots()
    {
        $sitemapUrl = config('app.url') . '/sitemap.xml';
        $content = "User-agent: *\nAllow: /\n\nSitemap: {$sitemapUrl}";
        
        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Generate XML sitemap.
     */
    public function index()
    {
        $urls = [];
        $baseUrl = config('app.url');
        $now = now()->toAtomString();

        // Homepage
        $urls[] = [
            'loc' => $baseUrl,
            'lastmod' => $now,
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // Blog index
        $urls[] = [
            'loc' => route('blog.index'),
            'lastmod' => $now,
            'changefreq' => 'daily',
            'priority' => '0.8',
        ];

        // Articles
        $articles = Article::published()->get();
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => route('blog.show', $article->slug),
                'lastmod' => $article->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Careers index
        $urls[] = [
            'loc' => route('careers.index'),
            'lastmod' => $now,
            'changefreq' => 'weekly',
            'priority' => '0.7',
        ];

        // Jobs
        $jobs = Job::where('is_active', true)->get();
        foreach ($jobs as $job) {
            $urls[] = [
                'loc' => route('careers.show', $job->slug),
                'lastmod' => $job->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        // Gallery
        $urls[] = [
            'loc' => route('gallery.index'),
            'lastmod' => $now,
            'changefreq' => 'weekly',
            'priority' => '0.6',
        ];

        // Services (if you have service detail pages)
        $services = Service::where('is_active', true)->get();
        foreach ($services as $service) {
            // Assuming you might have service detail pages in the future
            // $urls[] = [
            //     'loc' => route('services.show', $service->slug),
            //     'lastmod' => $service->updated_at->toAtomString(),
            //     'changefreq' => 'monthly',
            //     'priority' => '0.6',
            // ];
        }

        return response()->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'text/xml');
    }
}
