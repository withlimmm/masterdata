<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Article;
use App\Models\Portfolio;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama (Langsung hitung dari tabel DB untuk akurasi total)
        $stats = [
            'unread_messages' => Message::where('status', 'unread')->count(),
            'total_articles' => DB::table('articles')->count(),
            'active_projects' => DB::table('portfolios')->count(),
            'total_clients' => DB::table('clients')->count(),
        ];

        // 2. Aktivitas Terbaru (Gabungan Pesan, Artikel, Review)
        $recentMessages = Message::latest()->take(3)->get()->map(function($m) {
            return ['type' => 'message', 'title' => 'Pesan baru dari ' . $m->sender_name, 'time' => $m->created_at];
        });
        $recentArticles = Article::latest()->take(3)->get()->map(function($a) {
            return ['type' => 'article', 'title' => 'Artikel diterbitkan: ' . $a->title, 'time' => $a->created_at];
        });
        $recentReviews = \App\Models\Review::latest()->take(3)->get()->map(function($r) {
            return ['type' => 'review', 'title' => 'Ulasan masuk dari ' . $r->name, 'time' => $r->created_at];
        });

        $recentActivities = $recentMessages->concat($recentArticles)->concat($recentReviews)
            ->sortByDesc('time')->take(5);

        // 3. Statistik Kunjungan (Dummy Data untuk Grafik)
        $visitorStats = [
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'data' => [120, 150, 180, 220, 200, 300, 250]
        ];

        return view('admin.dashboard', compact('stats', 'recentActivities', 'visitorStats'));
    }
}