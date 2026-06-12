@extends('layouts.admin')

@section('title', 'Admin Dashboard - Rakira CMS')
@section('page_title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- Hero Section: Rakira CMS -->
        <section class="bg-slate-900 rounded-2xl p-8 lg:p-10 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="relative z-10 md:max-w-xl">
                <h2 class="text-3xl font-bold mb-4 tracking-tight">Selamat Datang di Rakira CMS</h2>
                <p class="text-slate-300 text-sm leading-relaxed mb-6">
                    Kelola seluruh konten website Anda dari satu pintu. Pantau artikel, portofolio proyek terbaru, hingga pesan dari pelanggan Anda secara real-time.
                </p>
                <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-slate-600 hover:border-slate-400 bg-slate-800/50 hover:bg-slate-700/50 text-white text-sm font-medium rounded-lg transition-all">
                    Tulis Artikel Baru
                </a>
            </div>
            
            <!-- Abstract Graphic / Illustration Placeholder -->
            <div class="relative z-10 w-full md:w-1/3 flex justify-end opacity-80">
                <div class="grid grid-cols-3 gap-2">
                    <div class="w-12 h-12 bg-indigo-500 rounded-full mix-blend-screen blur-md opacity-70 translate-y-4"></div>
                    <div class="w-16 h-16 bg-purple-500 rounded-full mix-blend-screen blur-md opacity-60"></div>
                    <div class="w-12 h-12 bg-pink-500 rounded-full mix-blend-screen blur-md opacity-80 translate-y-8"></div>
                </div>
            </div>

            <!-- Background Gradient Elements -->
            <div class="absolute right-0 top-0 w-96 h-96 bg-gradient-to-bl from-white/10 to-transparent rounded-full blur-3xl translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
        </section>

        <!-- Real Data Stats Cards -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: Artikel -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Total Artikel</h3>
                        <p class="text-xs text-slate-500">Konten blog / berita</p>
                    </div>
                    <div class="p-2 bg-blue-50 text-blue-500 rounded-lg">
                        <span class="material-symbols-outlined text-[20px]">article</span>
                    </div>
                </div>
                <div class="mt-auto">
                    <h2 class="text-3xl font-black text-slate-800">{{ $stats['total_articles'] ?? 0 }}</h2>
                </div>
            </div>

            <!-- Card 2: Portofolio -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Portofolio</h3>
                        <p class="text-xs text-slate-500">Karya & proyek aktif</p>
                    </div>
                    <div class="p-2 bg-purple-50 text-purple-500 rounded-lg">
                        <span class="material-symbols-outlined text-[20px]">work</span>
                    </div>
                </div>
                <div class="mt-auto">
                    <h2 class="text-3xl font-black text-slate-800">{{ $stats['active_projects'] ?? 0 }}</h2>
                </div>
            </div>

            <!-- Card 3: Klien -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Total Klien</h3>
                        <p class="text-xs text-slate-500">Klien terdaftar</p>
                    </div>
                    <div class="p-2 bg-emerald-50 text-emerald-500 rounded-lg">
                        <span class="material-symbols-outlined text-[20px]">groups</span>
                    </div>
                </div>
                <div class="mt-auto">
                    <h2 class="text-3xl font-black text-slate-800">{{ $stats['total_clients'] ?? 0 }}</h2>
                </div>
            </div>

            <!-- Card 4: Pesan Masuk -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Pesan Baru</h3>
                        <p class="text-xs text-slate-500">Inbox belum dibaca</p>
                    </div>
                    <div class="p-2 bg-amber-50 text-amber-500 rounded-lg">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                    </div>
                </div>
                <div class="mt-auto flex items-end justify-between relative z-10">
                    <h2 class="text-3xl font-black text-slate-800">{{ $stats['unread_messages'] ?? 0 }}</h2>
                    @if(isset($stats['unread_messages']) && $stats['unread_messages'] > 0)
                        <span class="inline-flex items-center justify-center px-2 py-1 rounded bg-red-50 text-red-600 text-[10px] font-bold">
                            Perlu dibalas
                        </span>
                    @endif
                </div>
                @if(isset($stats['unread_messages']) && $stats['unread_messages'] > 0)
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-50 rounded-full blur-xl opacity-50 z-0"></div>
                @endif
            </div>

        </section>

        <!-- Portofolio Terbaru Table -->
        <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Portofolio Terbaru</h3>
                    <p class="text-xs text-slate-500 mt-1">Data proyek yang baru saja ditambahkan</p>
                </div>
                <a href="{{ route('admin.portfolios.index') }}" class="text-xs font-bold text-blue-500 hover:text-blue-700 transition-colors flex items-center gap-1">
                    Lihat Semua <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase font-bold text-slate-400 border-b border-slate-100 bg-slate-50">
                            <th class="px-6 py-4 font-bold">NAMA PROYEK</th>
                            <th class="px-6 py-4 font-bold">KLIEN</th>
                            <th class="px-6 py-4 font-bold">KATEGORI</th>
                            <th class="px-6 py-4 font-bold">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($recentPortfolios ?? [] as $portfolio)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-white">
                                        <span class="material-symbols-outlined text-[16px]">work</span>
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $portfolio->title }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-600">
                                {{ $portfolio->client ? $portfolio->client->name : 'Tanpa Klien' }}
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-600">
                                <span class="px-2 py-1 bg-slate-100 rounded text-[10px] font-bold">{{ $portfolio->category ? $portfolio->category->name : 'Umum' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($portfolio->status === 'active')
                                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Published</span>
                                @else
                                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded">Draft</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500 text-xs">Belum ada portofolio yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Line Chart (Visitor) -->
            <section class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex flex-col">
                <div class="mb-4">
                    <h3 class="text-sm font-bold text-slate-800">Statistik Kunjungan</h3>
                    <p class="text-xs text-slate-500">Perbandingan 7 hari terakhir</p>
                </div>
                <div class="flex-1 h-[250px] w-full">
                    <canvas id="visitorChart"></canvas>
                </div>
            </section>

            <!-- Activity List -->
            <section class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm flex flex-col">
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-slate-800">Aktivitas Terbaru</h3>
                    <p class="text-xs text-slate-500">Ringkasan sistem secara real-time</p>
                </div>
                <div class="flex-1 overflow-y-auto max-h-[250px] pr-2 sidebar-scroll">
                    <ul class="space-y-6">
                        @forelse($recentActivities ?? [] as $activity)
                        <li class="flex gap-4 relative">
                            <div class="absolute left-[15px] top-8 bottom-[-24px] w-px bg-slate-200 last:hidden"></div>
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 z-10 
                                {{ $activity['type'] == 'message' ? 'bg-blue-50 text-blue-500' : '' }}
                                {{ $activity['type'] == 'article' ? 'bg-emerald-50 text-emerald-500' : '' }}
                                {{ $activity['type'] == 'review' ? 'bg-amber-50 text-amber-500' : 'bg-slate-100 text-slate-500' }}">
                                <span class="material-symbols-outlined text-[16px]">
                                    {{ $activity['type'] == 'message' ? 'mail' : '' }}
                                    {{ $activity['type'] == 'article' ? 'article' : '' }}
                                    {{ $activity['type'] == 'review' ? 'rate_review' : 'history' }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700 leading-tight">{{ $activity['title'] }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5 font-medium">{{ $activity['time']->diffForHumans() }}</p>
                            </div>
                        </li>
                        @empty
                        <li class="py-6 text-center text-slate-400">
                            <p class="text-xs font-bold">Belum ada aktivitas baru</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </section>
        </div>

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitorChart');
        if(ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($visitorStats['labels'] ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
                    datasets: [{
                        label: 'Kunjungan',
                        data: {!! json_encode($visitorStats['data'] ?? [12, 19, 15, 25, 22, 30, 28]) !!},
                        borderColor: '#22c55e', /* Emerald 500 */
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#22c55e',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 10,
                            titleFont: { size: 12, family: 'Inter' },
                            bodyFont: { size: 12, family: 'Inter' },
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [5, 5], color: '#f1f5f9', drawBorder: false },
                            ticks: { font: { size: 10, family: 'Inter' }, color: '#94a3b8' }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            ticks: { font: { size: 10, family: 'Inter' }, color: '#94a3b8' }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush