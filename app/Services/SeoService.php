<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Job;
use App\Models\Product;
use App\Models\SeoSetting;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;

class SeoService
{
    /**
     * Get SEO data for current page.
     */
    public static function getSeoData($model = null, $routeName = null, $defaults = [])
    {
        $seoData = [
            'meta_title' => null,
            'meta_description' => null,
            'meta_keywords' => null,
            'meta_robots' => 'index,follow',
            'canonical_url' => null,
            'og_title' => null,
            'og_description' => null,
            'og_image' => null,
            'og_type' => 'website',
            'og_url' => null,
            'og_site_name' => null,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => null,
            'twitter_description' => null,
            'twitter_image' => null,
            'twitter_site' => null,
            'twitter_creator' => null,
            'schema_json' => null,
        ];

        // Try to get from model first
        if ($model) {
            $seoSetting = SeoSetting::getByModel($model);
            if ($seoSetting) {
                $seoData = array_merge($seoData, $seoSetting->toArray());
            }
        }

        // Try to get from route name
        if (!$model && $routeName) {
            $seoSetting = SeoSetting::getByRoute($routeName);
            if ($seoSetting) {
                $seoData = array_merge($seoData, $seoSetting->toArray());
            }
        }

        // Apply defaults
        $seoData = array_merge($seoData, $defaults);

        // Get site settings for fallbacks
        $settings = Setting::getAllAsArray();
        $siteName = $settings['company_name'] ?? $settings['site_title'] ?? 'Daksa Company Profile';
        $siteDescription = $settings['site_description'] ?? 'Website Company Profile Daksa';
        $siteUrl = config('app.url');

        // Fill in missing values with defaults
        if (empty($seoData['meta_title'])) {
            $seoData['meta_title'] = $defaults['meta_title'] ?? $siteName;
        }

        if (empty($seoData['meta_description'])) {
            $seoData['meta_description'] = $defaults['meta_description'] ?? $siteDescription;
        }

        if (empty($seoData['og_title'])) {
            $seoData['og_title'] = $seoData['meta_title'];
        }

        if (empty($seoData['og_description'])) {
            $seoData['og_description'] = $seoData['meta_description'];
        }

        if (empty($seoData['og_image'])) {
            $seoData['og_image'] = $defaults['og_image'] ?? ($settings['logo'] ?? null);
        }

        if (empty($seoData['og_url'])) {
            $seoData['og_url'] = $defaults['og_url'] ?? URL::current();
        }

        if (empty($seoData['og_site_name'])) {
            $seoData['og_site_name'] = $siteName;
        }

        if (empty($seoData['twitter_title'])) {
            $seoData['twitter_title'] = $seoData['meta_title'];
        }

        if (empty($seoData['twitter_description'])) {
            $seoData['twitter_description'] = $seoData['meta_description'];
        }

        if (empty($seoData['twitter_image'])) {
            $seoData['twitter_image'] = $seoData['og_image'];
        }

        if (empty($seoData['canonical_url'])) {
            $seoData['canonical_url'] = URL::current();
        }

        // Process image URLs
        if ($seoData['og_image'] && !filter_var($seoData['og_image'], FILTER_VALIDATE_URL)) {
            $seoData['og_image'] = URL::to($seoData['og_image']);
        }

        if ($seoData['twitter_image'] && !filter_var($seoData['twitter_image'], FILTER_VALIDATE_URL)) {
            $seoData['twitter_image'] = URL::to($seoData['twitter_image']);
        }

        return $seoData;
    }

    /**
     * Generate Article SEO data.
     */
    public static function getArticleSeo(Article $article, $settings = [])
    {
        $defaults = [
            'meta_title' => $article->title . ' - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => $article->excerpt ?? strip_tags(substr($article->content, 0, 160)),
            'og_type' => 'article',
            'og_image' => $article->featured_image ?? null,
            'og_url' => route('blog.show', $article->slug),
        ];

        // Generate Article schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => $article->excerpt ?? strip_tags(substr($article->content, 0, 160)),
            'image' => $article->featured_image ? URL::to($article->featured_image) : null,
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified' => $article->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $article->author->name ?? 'Admin',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $settings['company_name'] ?? 'Daksa',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $settings['logo'] ? URL::to($settings['logo']) : null,
                ],
            ],
        ];

        $defaults['schema_json'] = $schema;

        return self::getSeoData($article, null, $defaults);
    }

    /**
     * Generate Product SEO data.
     */
    public static function getProductSeo(Product $product, $settings = [])
    {
        $defaults = [
            'meta_title' => $product->name . ' - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => $product->description ?? strip_tags(substr($product->description, 0, 160)),
            'og_type' => 'product',
            'og_image' => $product->image ?? null,
        ];

        // Generate Product schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $product->description,
            'image' => $product->image ? URL::to($product->image) : null,
            'offers' => [
                '@type' => 'Offer',
                'price' => $product->price,
                'priceCurrency' => 'IDR',
            ],
        ];

        $defaults['schema_json'] = $schema;

        return self::getSeoData($product, null, $defaults);
    }

    /**
     * Generate Organization schema.
     */
    public static function getOrganizationSchema($settings = [])
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $settings['company_name'] ?? 'Daksa',
            'url' => config('app.url'),
            'logo' => $settings['logo'] ? URL::to($settings['logo']) : null,
            'description' => $settings['company_description'] ?? $settings['site_description'] ?? null,
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $settings['company_phone'] ?? null,
                'contactType' => 'customer service',
                'email' => $settings['company_email'] ?? null,
            ],
            'sameAs' => array_filter([
                $settings['facebook_url'] ?? null,
                $settings['instagram_url'] ?? null,
                $settings['linkedin_url'] ?? null,
            ]),
        ];
    }

    /**
     * Generate Website schema.
     */
    public static function getWebsiteSchema($settings = [])
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $settings['company_name'] ?? 'Daksa',
            'url' => config('app.url'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => config('app.url') . '/blog?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Generate Job SEO data.
     */
    public static function getJobSeo(Job $job, $settings = [])
    {
        $defaults = [
            'meta_title' => $job->title . ' - Karier - ' . ($settings['company_name'] ?? 'Daksa'),
            'meta_description' => $job->short_description ?? strip_tags(substr($job->description, 0, 160)),
            'og_type' => 'article',
            'og_url' => route('careers.show', $job->slug),
        ];

        // Generate JobPosting schema
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => $job->title,
            'description' => $job->description,
            'datePosted' => $job->created_at->toIso8601String(),
            'validThrough' => $job->deadline?->toIso8601String(),
            'employmentType' => $job->employment_type ?? 'FULL_TIME',
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => $settings['company_name'] ?? 'Daksa',
                'sameAs' => config('app.url'),
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job->location ?? '',
                ],
            ],
        ];

        if ($job->salary_range) {
            $schema['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => 'IDR',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'value' => $job->salary_range,
                ],
            ];
        }

        $defaults['schema_json'] = $schema;

        return self::getSeoData($job, null, $defaults);
    }
}

