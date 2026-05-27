<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SitemapController extends Controller
{
    /**
     * Generate the main XML sitemap dynamically.
     * Includes all public pages, services, portfolios, and articles.
     */
    public function index(): Response
    {
        $urls = [];

        // Static pages
        $staticPages = [
            ['url' => url('/'),               'priority' => '1.0',  'changefreq' => 'weekly',  'lastmod' => now()->toDateString()],
            ['url' => url('/layanan'),         'priority' => '0.9',  'changefreq' => 'weekly',  'lastmod' => now()->toDateString()],
            ['url' => url('/portofolio'),      'priority' => '0.8',  'changefreq' => 'weekly',  'lastmod' => now()->toDateString()],
            ['url' => url('/tentang-kami'),    'priority' => '0.8',  'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['url' => url('/blog'),            'priority' => '0.8',  'changefreq' => 'daily',   'lastmod' => now()->toDateString()],
        ];

        $urls = array_merge($urls, $staticPages);

        // Dynamic: Services
        if (Schema::hasTable('services')) {
            $services = Service::where('status', 'active')->get();
            foreach ($services as $service) {
                $urls[] = [
                    'url'        => url('/layanan/' . $service->slug),
                    'priority'   => '0.8',
                    'changefreq' => 'weekly',
                    'lastmod'    => $service->updated_at ? $service->updated_at->toDateString() : now()->toDateString(),
                ];
            }
        }

        // Dynamic: Portfolios
        if (Schema::hasTable('portfolios')) {
            $portfolios = Portfolio::latest()->get();
            foreach ($portfolios as $portfolio) {
                $urls[] = [
                    'url'        => url('/portofolio/' . $portfolio->slug),
                    'priority'   => '0.7',
                    'changefreq' => 'monthly',
                    'lastmod'    => $portfolio->updated_at ? $portfolio->updated_at->toDateString() : now()->toDateString(),
                ];
            }
        }

        // Dynamic: Blog articles
        if (Schema::hasTable('articles')) {
            $articles = Article::with('category')->latest()->get();
            foreach ($articles as $article) {
                $urls[] = [
                    'url'        => url('/blog/' . $article->slug),
                    'priority'   => '0.7',
                    'changefreq' => 'weekly',
                    'lastmod'    => $article->updated_at ? $article->updated_at->toDateString() : now()->toDateString(),
                ];
            }
        }

        // Prepend XML declaration in PHP — keeps Blade templates free of <?xml syntax
        $xmlProlog = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $content   = $xmlProlog . view('sitemap.index', compact('urls'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * Generate image sitemap for portfolio and service images.
     *
     * We build the namespaced <image:*> XML fragment as a PHP string here
     * instead of in the Blade template to avoid IDE false-positive errors
     * caused by XML namespace prefixes (image:image, image:loc, etc.)
     *
     * Field reference:
     *   Portfolio → thumbnail_image, project_name, description, slug
     *   Service   → icon_image (Material Icon name, NOT a file path — skip)
     */
    public function images(): Response
    {
        $imageUrls = [];

        if (Schema::hasTable('portfolios')) {
            $portfolios = Portfolio::latest()->get();
            foreach ($portfolios as $portfolio) {
                if (empty($portfolio->thumbnail_image)) {
                    continue;
                }

                $title   = e($portfolio->project_name ?? 'Portfolio Rakira Digital');
                $caption = e(\Illuminate\Support\Str::limit(
                    strip_tags($portfolio->description ?? 'Portofolio digital dari Rakira Digital Nusantara'),
                    100
                ));
                $imgUrl  = e(asset('storage/' . $portfolio->thumbnail_image));

                // Build namespaced XML as a raw string — avoids IDE errors in Blade
                $imageXml = "<image:image>\n"
                    . "            <image:loc>{$imgUrl}</image:loc>\n"
                    . "            <image:title>{$title}</image:title>\n"
                    . "            <image:caption>{$caption}</image:caption>\n"
                    . "        </image:image>";

                $imageUrls[] = [
                    'page_url'  => url('/portofolio/' . $portfolio->slug),
                    'image_xml' => $imageXml,
                ];
            }
        }

        // Services use 'icon_image' which stores a Material Symbols name (text string),
        // not a file path. Only include if it looks like an actual storage path (has '/').
        if (Schema::hasTable('services')) {
            $services = Service::where('status', 'active')->get();
            foreach ($services as $service) {
                if (empty($service->icon_image) || ! str_contains($service->icon_image, '/')) {
                    continue;
                }

                $title   = e($service->title ?? 'Layanan Rakira Digital');
                $caption = e(\Illuminate\Support\Str::limit(
                    strip_tags($service->short_description ?? 'Layanan digital profesional dari Rakira Digital'),
                    100
                ));
                $imgUrl  = e(asset('storage/' . $service->icon_image));

                $imageXml = "<image:image>\n"
                    . "            <image:loc>{$imgUrl}</image:loc>\n"
                    . "            <image:title>{$title}</image:title>\n"
                    . "            <image:caption>{$caption}</image:caption>\n"
                    . "        </image:image>";

                $imageUrls[] = [
                    'page_url'  => url('/layanan/' . $service->slug),
                    'image_xml' => $imageXml,
                ];
            }
        }

        // Prepend XML declaration in PHP — keeps Blade templates free of <?xml syntax
        $xmlProlog = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $content   = $xmlProlog . view('sitemap.images', compact('imageUrls'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
