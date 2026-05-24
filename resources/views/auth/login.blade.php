<x-guest-layout>
    <div class="grid gap-8 lg:grid-cols-[1.05fr_0.95fr] items-stretch">
        <section class="glass-panel relative overflow-hidden p-8 md:p-10 text-white shadow-soft" data-aos="fade-right">
            <div class="absolute inset-0 bg-gradient-to-br from-primary via-[#00526f] to-primary-container"></div>
            <div class="absolute -right-20 top-10 h-56 w-56 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full bg-black/10 blur-3xl"></div>

            <div class="relative z-10 flex h-full flex-col justify-between gap-10">
                <div class="space-y-5">
                    <span class="section-kicker border-white/15 bg-white/10 text-white">Admin Access</span>
                    <h1 class="text-4xl font-black tracking-tight md:text-5xl">Masuk ke panel admin dengan tampilan yang bersih dan aman.</h1>
                    <p class="max-w-xl text-white/85 md:text-lg">Satu pintu untuk mengelola artikel, layanan, portofolio, dan konten perusahaan dengan alur yang nyaman di desktop maupun mobile.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md" data-aos="zoom-in" data-aos-delay="100">
                        <p class="text-2xl font-black">24/7</p>
                        <p class="text-sm text-white/80">Akses dashboard</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md" data-aos="zoom-in" data-aos-delay="200">
                        <p class="text-2xl font-black">Role</p>
                        <p class="text-sm text-white/80">Super admin & editor</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 backdrop-blur-md" data-aos="zoom-in" data-aos-delay="300">
                        <p class="text-2xl font-black">Fast</p>
                        <p class="text-sm text-white/80">Vite + Tailwind</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="surface-card p-6 md:p-10" data-aos="fade-left" data-aos-delay="150">
            <div class="mb-8 text-center">
                <img src="/images/logo-rakira.png" alt="Rakira Digital" class="mx-auto mb-5 h-16 w-16">
                <h2 class="text-2xl font-black text-on-surface">Rakira Digital Nusantara</h2>
                <p class="mt-2 text-sm font-semibold text-on-surface-variant">CMS Management Login</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="block text-xs font-black uppercase tracking-[0.2em] text-on-surface" for="email">Email Address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined pointer-events-none absolute inset-y-0 left-4 flex items-center text-on-surface-variant">mail</span>
                        <input class="block w-full rounded-xl border border-outline-variant/60 bg-white px-4 py-3 pl-11 text-sm transition-all focus:border-primary focus:ring-4 focus:ring-primary/10" id="email" name="email" value="{{ old('email') }}" placeholder="admin@companyprofile.test" required autofocus>
                    </div>
                    @error('email') <p class="mt-1 text-xs font-semibold text-error">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between gap-4">
                        <label class="block text-xs font-black uppercase tracking-[0.2em] text-on-surface" for="password">Password</label>
                        @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-primary hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined pointer-events-none absolute inset-y-0 left-4 flex items-center text-on-surface-variant">lock</span>
                        <input class="block w-full rounded-xl border border-outline-variant/60 bg-white px-4 py-3 pl-11 text-sm transition-all focus:border-primary focus:ring-4 focus:ring-primary/10" id="password" name="password" placeholder="••••••••" required type="password">
                    </div>
                </div>

                <label class="flex items-center gap-3 text-sm font-semibold text-on-surface-variant">
                    <input class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary" id="remember-me" name="remember" type="checkbox">
                    Remember me for 30 days
                </label>

                <button class="btn-primary flex w-full items-center justify-center gap-2 py-3.5 text-base shadow-md" type="submit">
                    <span>Login Admin</span>
                    <span class="material-symbols-outlined text-xl">arrow_forward</span>
                </button>
            </form>

            <div class="mt-8 border-t border-outline-variant/40 pt-6 text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-on-surface-variant">Secure Access Portal</p>
            </div>
        </section>
    </div>
</x-guest-layout>
