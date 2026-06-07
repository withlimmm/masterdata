<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rakira Digital Nusantara</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(0, 159, 227, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(0, 159, 227, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        .btn-primary {
            background: linear-gradient(135deg, #009fe3 0%, #0077b3 100%);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px #009fe3;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Dekorasi Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-blue-300/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Login Card -->
    <div class="glass-card rounded-[2rem] w-full max-w-md p-8 md:p-10 relative z-10">
        
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <div class="w-20 h-20 rounded-2xl bg-white shadow-sm flex items-center justify-center p-3 border border-slate-100">
                <!-- Gunakan logo Rakira jika ada -->
                <img src="/images/logo-rakira.png" alt="Rakira Logo" class="w-full h-full object-contain" onerror="this.src='https://ui-avatars.com/api/?name=Rakira&background=009fe3&color=fff&rounded=true'">
            </div>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Selamat Datang</h1>
            <p class="text-sm text-slate-500 mt-2">Silakan masuk ke panel Rakira CMS</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:ring-2 focus:ring-[#009fe3]/30 focus:border-[#009fe3] outline-none transition-all placeholder:text-slate-400"
                           placeholder="admin@rakiradigital.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-xs font-bold text-slate-600 uppercase tracking-wider">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-[#009fe3] hover:underline">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </span>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:ring-2 focus:ring-[#009fe3]/30 focus:border-[#009fe3] outline-none transition-all placeholder:text-slate-400"
                           placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-[#009fe3] shadow-sm focus:ring-[#009fe3]">
                    <span class="ml-2 text-sm text-slate-600 font-medium">Ingat Saya</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary w-full py-3.5 rounded-xl text-sm font-bold tracking-wide mt-2">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 text-center border-t border-slate-100 pt-6">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} Rakira Digital Nusantara.<br>Sistem Terproteksi.
            </p>
        </div>
    </div>

</body>
</html>
