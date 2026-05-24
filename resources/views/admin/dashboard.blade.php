@extends('layouts.admin')

@section('title', 'Admin Dashboard - Rakira CMS')
@section('page_title', 'Dashboard Overview')
@section('page_subtitle', 'Manage and monitor your digital ecosystem.')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Quick Actions Bento -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('admin.articles.create') }}"
                class="group relative overflow-hidden bg-white p-6 rounded-2xl border border-outline-variant/30 hover:border-primary/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl">edit_square</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface text-lg">Buat Artikel</p>
                        <p class="text-xs text-on-surface-variant">Update blog terbaru</p>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">article</span>
                </div>
            </a>

            <a href="{{ route('admin.portfolios.create') }}"
                class="group relative overflow-hidden bg-white p-6 rounded-2xl border border-outline-variant/30 hover:border-secondary/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl">add_photo_alternate</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface text-lg">Tambah Proyek</p>
                        <p class="text-xs text-on-surface-variant">Update portofolio klien</p>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">work</span>
                </div>
            </a>

            <a href="{{ route('admin.messages.index') }}"
                class="group relative overflow-hidden bg-white p-6 rounded-2xl border border-outline-variant/30 hover:border-primary/50 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-5">
                    <div class="w-12 h-12 rounded-xl bg-surface-container-high text-on-surface flex items-center justify-center group-hover:bg-on-surface group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-2xl">mail</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface text-lg">Cek Pesan</p>
                        <p class="text-xs text-on-surface-variant">Lihat konsultasi masuk</p>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">chat_bubble</span>
                </div>
            </a>
        </section>

        <!-- Summary Widgets -->
        <section class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white border border-outline-variant/30 rounded-xl p-6 flex flex-col gap-2">
                <span class="text-on-surface-variant font-semibold text-xs uppercase tracking-wider">Pesan Baru</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['unread_messages'] }}</span>
                    @if($stats['unread_messages'] > 0)
                        <span class="text-[10px] bg-red-50 text-red-600 px-2 py-0.5 rounded-full font-black uppercase tracking-tighter">Baru</span>
                    @endif
                </div>
            </div>
            <div class="bg-white border border-outline-variant/30 rounded-xl p-6 flex flex-col gap-2 border-t-4 border-t-primary shadow-sm">
                <span class="text-on-surface-variant font-semibold text-xs uppercase tracking-wider">Total Artikel</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['total_articles'] }}</span>
                </div>
            </div>
            <div class="bg-white border border-outline-variant/30 rounded-xl p-6 flex flex-col gap-2">
                <span class="text-on-surface-variant font-semibold text-xs uppercase tracking-wider">Portfolio</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['active_projects'] }}</span>
                </div>
            </div>
            <div class="bg-white border border-outline-variant/30 rounded-xl p-6 flex flex-col gap-2">
                <span class="text-on-surface-variant font-semibold text-xs uppercase tracking-wider">Total Klien</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-on-surface">{{ $stats['total_clients'] }}</span>
                </div>
            </div>
        </section>

        <!-- Charts & Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Visit Statistics -->
            <section class="lg:col-span-2 bg-white border border-outline-variant/30 rounded-xl flex flex-col shadow-sm">
                <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-slate-50/50">
                    <h2 class="text-lg font-bold text-on-surface font-headline">Statistik Kunjungan</h2>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">7 Hari Terakhir</span>
                </div>
                <div class="p-6 flex-1 h-[350px]">
                    <canvas id="visitorChart"></canvas>
                </div>
            </section>

            <!-- Recent Activity -->
            <section class="bg-white border border-outline-variant/30 rounded-xl flex flex-col shadow-sm">
                <div class="p-6 border-b border-outline-variant/30 bg-slate-50/50">
                    <h2 class="text-lg font-bold text-on-surface font-headline">Aktivitas Terbaru</h2>
                </div>
                <div class="p-6 flex-1 overflow-y-auto max-h-[400px]">
                    <ul class="space-y-8">
                        @forelse($recentActivities as $activity)
                        <li class="flex gap-4 relative">
                            <div class="absolute left-4 top-8 bottom-[-32px] w-px bg-slate-100 last:hidden"></div>
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 z-10 shadow-sm
                                {{ $activity['type'] == 'message' ? 'bg-blue-50 text-blue-600' : '' }}
                                {{ $activity['type'] == 'article' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                {{ $activity['type'] == 'review' ? 'bg-amber-50 text-amber-600' : '' }}">
                                <span class="material-symbols-outlined text-[18px]">
                                    {{ $activity['type'] == 'message' ? 'mail' : '' }}
                                    {{ $activity['type'] == 'article' ? 'article' : '' }}
                                    {{ $activity['type'] == 'review' ? 'rate_review' : '' }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700 leading-tight">{{ $activity['title'] }}</p>
                                <p class="text-[10px] text-slate-400 mt-1 font-medium">{{ $activity['time']->diffForHumans() }}</p>
                            </div>
                        </li>
                        @empty
                        <li class="py-10 text-center text-slate-300">
                            <p class="text-xs font-black uppercase tracking-widest">Belum ada aktivitas</p>
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
        const ctx = document.getElementById('visitorChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($visitorStats['labels']),
                datasets: [{
                    label: 'Kunjungan',
                    data: @json($visitorStats['data']),
                    borderColor: '#006491',
                    backgroundColor: 'rgba(0, 100, 145, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#006491',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f1f5f9' },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#94a3b8' }
                    }
                }
            }
        });
    });
</script>
@endpush