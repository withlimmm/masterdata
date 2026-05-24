<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'slug' => 'web-development',
                'icon_image' => 'web',
                'short_description' => 'Pengembangan website profesional untuk berbagai kebutuhan bisnis Anda.',
                'full_description' => "Kami membangun website berkualitas tinggi dengan arsitektur modern yang memastikan performa cepat, mudah dikembangkan, dan aman.\n\nLayanan meliputi:\n• Company Profile Website\n• E-Commerce Website\n• Custom Web Application\n• Landing Page & Branding Website\n• Dashboard Admin System\n\nTeknologi: Laravel, Next.js, React, Vue.js, PostgreSQL, Cloud Infrastructure.",
                'status' => 'active',
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'icon_image' => 'smartphone',
                'short_description' => 'Pembuatan aplikasi mobile Android & iOS yang intuitif dan berfokus pada performa.',
                'full_description' => "Kami mengembangkan aplikasi mobile native dan cross-platform yang dirancang khusus untuk kebutuhan bisnis Anda.\n\nLayanan meliputi:\n• Aplikasi Bisnis\n• Aplikasi Marketplace\n• Aplikasi Booking & Reservation\n• Aplikasi Internal Perusahaan\n• UI/UX Mobile Design\n\nTeknologi: Flutter, React Native, Kotlin, Swift.",
                'status' => 'active',
            ],
            [
                'title' => 'Digital Solution & IT Consulting',
                'slug' => 'digital-solution-it-consulting',
                'icon_image' => 'lightbulb',
                'short_description' => 'Konsultasi transformasi digital dan solusi IT terintegrasi untuk bisnis Anda.',
                'full_description' => "Kami membantu bisnis Anda bertransformasi secara digital dengan strategi yang tepat dan implementasi yang terukur.\n\nLayanan meliputi:\n• Konsultasi Transformasi Digital\n• System Integration\n• Maintenance & Support\n• SEO & Website Optimization\n\nKami akan mendampingi Anda dari perencanaan hingga eksekusi.",
                'status' => 'active',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
