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
use App\Models\CompanySetting;
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

    $settings = \App\Models\CompanySetting::first();
    $whatsAppNumber = $settings?->phone ?? '6287868184742';
    $whatsAppText = 'Halo, saya ingin konsultasi layanan digital untuk website dan company profile.';
    $whatsAppUrl = 'https://wa.me/' . $whatsAppNumber . '?text=' . urlencode($whatsAppText);

    return view('welcome', compact('clients', 'client_logos', 'faqs', 'services', 'whatsAppNumber', 'whatsAppText', 'whatsAppUrl'));
})->name('home');

Route::get('/layanan', function () {
    $services = collect();
    if (Schema::hasTable('services')) {
        $services = \App\Models\Service::where('status', 'active')->latest()->get();
    }

    return view('services', compact('services'));
})->name('services');

Route::get('/layanan/{slug}', function ($slug) {
    $service = \App\Models\Service::where('slug', $slug)->firstOrFail();
    return view('services.show', compact('service'));
})->name('services.show');

Route::get('/portofolio', function () {
    $categories = collect();
    $portfolios = collect();

    if (Schema::hasTable('categories')) {
        $categories = \App\Models\Category::all();
    }

    if (Schema::hasTable('portfolios')) {
        $portfolios = \App\Models\Portfolio::with('category')->latest()->get();
    }

    return view('portfolio', compact('categories', 'portfolios'));
})->name('portfolio');

Route::get('/portofolio/{slug}', function ($slug) {
    $portfolio = \App\Models\Portfolio::with('category')->where('slug', $slug)->firstOrFail();
    return view('portfolio-detail', compact('portfolio'));
})->name('portfolio.show');

Route::get('/tentang-kami', function () {
    $teams = collect();
    if (Schema::hasTable('teams')) {
        $teams = Team::latest()->get();
    }

    return view('about', compact('teams'));
})->name('about');

Route::get('/blog', function () {
    $categories = collect();
    $articles = collect();

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

    return view('blog', compact('categories', 'articles'));
})->name('blog');

Route::get('/blog/{slug}', function (string $slug) {
    if (! Schema::hasTable('articles')) {
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

    return view('blog-detail', compact('article', 'related_articles'));
})->name('blog.show');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::resource('articles', ArticleController::class);
    Route::resource('messages', MessageController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('client-projects', ClientProjectController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('teams', TeamController::class);

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::post('/konsultasi', function (Request $request) {
    $validated = $request->validate([
        'sender_name' => 'required|string|max:150',
        'sender_email' => 'required|email|max:150',
        'phone' => 'required|string|max:30',
        'service' => 'required|string|max:150',
        'message_body' => 'nullable|string|max:1000',
    ]);

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

    $validated['status'] = 'pending';

    \App\Models\Review::create($validated);

    return redirect()->route('home')->with('success_review', 'Terima kasih! Ulasan Anda telah terkirim dan menunggu moderasi admin.');
})->name('review.store')->middleware('throttle:3,1');