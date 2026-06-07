<?php

use App\Http\Controllers\ProfileController;
use App\Models\Client;
use App\Models\Article;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Review;
use App\Models\Team; 
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\CompanyConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ClientProjectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\SaasTenantController;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| SEO: Sitemap Routes
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-images.xml', [SitemapController::class, 'images'])->name('sitemap.images');

/*
|--------------------------------------------------------------------------
| SaaS Public API — dipanggil dari domain client untuk cek status
| GET /api/saas/check?domain=akagroupconsulting.com&key=xxx
|--------------------------------------------------------------------------
*/
Route::get('/api/saas/check', [\App\Http\Controllers\Api\SaaSCheckController::class, 'check'])->name('saas.check');


/*
|--------------------------------------------------------------------------
| Public Routes (Company Profile)
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', function () {
    $public_reviews = collect();
    if (Schema::hasTable('reviews')) {
        $public_reviews = \App\Models\Review::where('status', 'approved')
            ->latest()
            ->get()
            ->map(function ($review) {
                return [
                    'name' => $review->name,
                    'company' => $review->company ?: 'Klien Rakira',
                    'testimonial' => $review->comment ?? $review->testimonial,
                    'initial' => strtoupper(substr($review->name, 0, 1)),
                    'rating' => $review->rating ?? 5,
                ];
            });
    }

    $admin_clients = collect();
    if (Schema::hasTable('clients')) {
        $admin_clients = \App\Models\Client::where('status', 'active')
            ->whereNotNull('testimonial')
            ->latest()
            ->get()
            ->map(function ($client) {
                return [
                    'name' => $client->client_name,
                    'company' => $client->company_name ?: 'Mitra Strategis',
                    'testimonial' => $client->testimonial,
                    'initial' => strtoupper(substr($client->client_name, 0, 1)),
                    'rating' => $client->rating ?? 5,
                ];
            });
    }

    $clients = $public_reviews->toBase()->merge($admin_clients->toBase())->take(9)->values();

    $client_logos = collect();
    if (Schema::hasTable('clients')) {
        $client_logos = \App\Models\Client::where('status', 'active')
            ->latest()
            ->get()
            ->map(function ($client) {
                return $client->toArray();
            });
    }
    $client_logos = collect($client_logos)->map(function ($client) {
        return (object) $client;
    });

    $faqs = collect();
    if (Schema::hasTable('faqs')) {
        $faqs = Faq::where('status', 'active')
            ->orderBy('sort_order')
            ->latest()
            ->get()
            ->map(function ($faq) {
                return [
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                ];
            });
    }
    $faqs = collect($faqs)
        ->filter(function ($faq) {
            $question = trim((string) data_get($faq, 'question', ''));
            $answer = trim((string) data_get($faq, 'answer', ''));

            return $question !== '' && $answer !== '';
        })
        ->values();

    $services = collect();
    if (Schema::hasTable('services')) {
        $services = \App\Models\Service::where('status', 'active')
            ->latest()
            ->get()
            ->map(function ($service) {
                return $service->toArray();
            });
    }
    $services = collect($services)->map(function ($service) {
        return (object) $service;
    });

    $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    $whatsAppNumber = $settings?->cfg_phone ?? '6287868184742';
    $whatsAppText = 'Halo, saya ingin konsultasi layanan digital untuk website dan company profile.';
    $whatsAppUrl = 'https://wa.me/' . $whatsAppNumber . '?text=' . urlencode($whatsAppText);

    return view('welcome', compact('clients', 'client_logos', 'faqs', 'services', 'whatsAppNumber', 'whatsAppText', 'whatsAppUrl', 'settings'));
})->name('home');

Route::get('/layanan', function () {
    $services = collect();
    $settings = null;
    if (Schema::hasTable('services')) {
        $services = \App\Models\Service::where('status', 'active')->latest()->get();
    }
    if (Schema::hasTable('company_settings')) {
        $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    }

    return view('services', compact('services', 'settings'));
})->name('services');

Route::get('/layanan/{slug}', function ($slug) {
    $service = \App\Models\Service::where('slug', $slug)->firstOrFail();
    $settings = null;
    if (Schema::hasTable('company_settings')) {
        $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    }
    return view('services.show', compact('service', 'settings'));
})->name('services.show');

Route::get('/portofolio', function () {
    $categories = collect();
    $portfolios = collect();
    $settings = null;

    if (Schema::hasTable('categories')) {
        $categories = \App\Models\Category::all();
    }

    if (Schema::hasTable('portfolios')) {
        $portfolios = \App\Models\Portfolio::with('category')->latest()->get();
    }

    if (Schema::hasTable('company_settings')) {
        $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    }

    return view('portfolio', compact('categories', 'portfolios', 'settings'));
})->name('portfolio');

Route::get('/portofolio/{slug}', function ($slug) {
    $portfolio = \App\Models\Portfolio::with('category')->where('slug', $slug)->firstOrFail();
    $settings = null;
    if (Schema::hasTable('company_settings')) {
        $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    }
    return view('portfolio-detail', compact('portfolio', 'settings'));
})->name('portfolio.show');

Route::get('/tentang-kami', function () {
    $teams = collect();
    $settings = null;
    if (Schema::hasTable('teams')) {
        $teams = Team::latest()->get();
    }
    if (Schema::hasTable('company_settings')) {
        $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    }

    return view('about', compact('teams', 'settings'));
})->name('about');

Route::get('/blog', function () {
    $categories = collect();
    $articles = collect();
    $settings = null;

    if (Schema::hasTable('categories')) {
        $categories = Category::with('articles')->get();
    }

    if (Schema::hasTable('articles')) {
        $articles = Article::with(['category', 'author'])->latest()->get();

        if (request()->filled('category')) {
            $categorySlug = request('category');
            $articles = $articles->filter(function ($article) use ($categorySlug) {
                return optional($article->category)->slug === $categorySlug;
            })->values();
        }
    }

    if (Schema::hasTable('company_settings')) {
        $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    }

    return view('blog', compact('categories', 'articles', 'settings'));
})->name('blog');

Route::get('/blog/{slug}', function (string $slug) {
    if (!Schema::hasTable('articles')) {
        abort(404);
    }

    $article = Article::with(['category', 'author'])
        ->where('slug', $slug)
        ->firstOrFail();

    $related_articles = Article::with(['category', 'author'])
        ->where('id', '!=', $article->id)
        ->when($article->category_id, function ($query) use ($article) {
            $query->where('category_id', $article->category_id);
        })
        ->latest()
        ->take(3)
        ->get();

    if ($related_articles->isEmpty()) {
        $related_articles = Article::with(['category', 'author'])
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();
    }

    $settings = null;
    if (Schema::hasTable('company_settings')) {
        $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    }

    return view('blog-detail', compact('article', 'related_articles', 'settings'));
})->name('blog.show');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Legal Pages
Route::get('/privacy-policy', function () {
    $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    return view('pages.privacy', compact('settings'));
})->name('privacy');

Route::get('/terms-of-service', function () {
    $settings = (app()->bound("tenant") ? app("tenant")->config : \App\Models\CompanyConfig::first());
    return view('pages.terms', compact('settings'));
})->name('terms');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes (Protected by Auth)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('portfolios', PortfolioController::class);
    Route::resource('pages', PageController::class);
    
    // User Management for Tenant
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);
    
    Route::resource('articles', ArticleController::class);
    Route::resource('messages', MessageController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('client-projects', ClientProjectController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('teams', TeamController::class);

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::middleware('super_admin')->group(function () {
        Route::resource('packages', App\Http\Controllers\Admin\PackageController::class);
        Route::post('companies/{company}/regenerate-key', [App\Http\Controllers\Admin\CompanyController::class, 'regenerateApiKey'])->name('companies.regenerate-key');
        Route::resource('companies', App\Http\Controllers\Admin\CompanyController::class);
    });
});

Route::post('/konsultasi', function (Request $request) {
    $validated = $request->validate([
        'sender_name' => 'required|string|max:150',
        'sender_email' => 'required|email|max:150',
        'phone' => 'required|string|max:30',
        'service' => 'required|string|max:150',
        'message_body' => 'nullable|string|max:1000',
    ]);

    // Verify reCAPTCHA
    if (config('services.recaptcha.secret')) {
        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->successful() || !$response->json('success') || $response->json('score') < 0.5) {
            return redirect()->back()->with('error', 'Validasi keamanan (Anti-Spam) gagal. Silakan coba lagi.');
        }
    }

    $validated['subject'] = 'Konsultasi: ' . $validated['service'];
    $validated['message_body'] = $validated['message_body'] ?: 'Saya ingin konsultasi mengenai layanan ' . $validated['service'];
    $validated['status'] = 'unread';

    \App\Models\Message::create($validated);

    return redirect()->route('home')->with('success', 'Terima kasih! Pesan konsultasi Anda telah terkirim. Tim kami akan segera menghubungi Anda.');
})->name('konsultasi.store')->middleware('throttle:3,1');

Route::post('/review', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:150',
        'company' => 'nullable|string|max:150',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000',
    ]);

    // Verify reCAPTCHA
    if (config('services.recaptcha.secret')) {
        $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->successful() || !$response->json('success') || $response->json('score') < 0.5) {
            return redirect()->back()->with('error', 'Validasi keamanan (Anti-Spam) gagal. Silakan coba lagi.');
        }
    }

    $validated['status'] = 'pending';

    \App\Models\Review::create($validated);

    return redirect()->route('home')->with('success_review', 'Terima kasih! Ulasan Anda telah terkirim dan menunggu moderasi admin.');
})->name('review.store')->middleware('throttle:3,1');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
