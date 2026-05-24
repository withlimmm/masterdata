<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Faq;
use App\Models\Review;
use App\Models\Client;
use App\Models\Page;
use App\Models\Service;

class CompanyProfileController extends Controller
{
    public function showProfile(Request $request)
    {
        // 1. Ambil data dari database (sama seperti di routes/web.php)
        $public_reviews = collect();
        if (Schema::hasTable('reviews')) {
            $public_reviews = Review::where('status', 'approved')
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
            $admin_clients = Client::where('status', 'active')
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

        $clients = $public_reviews->toBase()->merge($admin_clients->toBase())->take(9);

        $client_logos = collect();
        if (Schema::hasTable('clients')) {
            $client_logos = collect(
                Client::where('status', 'active')
                    ->latest()
                    ->get()
                    ->map(function ($client) {
                        return $client->toArray();
                    })
                    ->all()
            )->map(function ($client) {
                return (object) $client;
            });
        }

        $faqs = collect();
        if (Schema::hasTable('faqs')) {
            $faqs = collect(
                Faq::where('status', 'active')
                    ->orderBy('sort_order')
                    ->latest()
                    ->get()
                    ->map(function ($faq) {
                        return [
                            'question' => $faq->question,
                            'answer' => $faq->answer,
                        ];
                    })
                    ->all()
            )->filter(function ($faq) {
                return trim((string) data_get($faq, 'question', '')) !== ''
                    && trim((string) data_get($faq, 'answer', '')) !== '';
            })->values();
        }

        $services = collect();
        if (Schema::hasTable('services')) {
            $services = collect(
                Service::where('status', 'active')
                    ->latest()
                    ->get()
                    ->map(function ($service) {
                        return $service->toArray();
                    })
                    ->all()
            )->map(function ($service) {
                return (object) $service;
            });
        }

        $settings = \App\Models\CompanySetting::first();
        $whatsAppNumber = $settings?->phone ?? '6287868184742';
        $whatsAppText = 'Halo, saya ingin konsultasi layanan digital untuk website dan company profile.';
        $whatsAppUrl = 'https://wa.me/' . $whatsAppNumber . '?text=' . urlencode($whatsAppText);

        // 2. Cek parameter 'theme' di URL dan simpan ke session
        if ($request->has('theme')) {
            $theme = $request->query('theme');
            if (in_array($theme, ['default', 'premium'])) {
                session(['theme' => $theme]);
            }
        }
        
        $theme = session('theme', 'default');

        // 3. Arahkan ke folder template yang sesuai secara dinamis
        return view("templates.{$theme}.index", [
            'clients' => $clients,
            'client_logos' => $client_logos,
            'faqs' => $faqs,
            'services' => $services,
            'whatsAppNumber' => $whatsAppNumber,
            'whatsAppText' => $whatsAppText,
            'whatsAppUrl' => $whatsAppUrl,
        ]);
    }
}
