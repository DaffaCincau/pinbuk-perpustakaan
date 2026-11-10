<x-guest-layout :title="'Masuk'">

    {{-- Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-text-muted hover:text-primary transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Selamat Datang Kembali 👋</h2>
        <p class="text-sm text-text-secondary mt-1">Masuk ke akun PINBUK kamu.</p>
    </div>

    @if (session('status'))
        <div class="mb-4 alert alert-success">
            <p class="text-sm">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="label-field">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                   class="input-field @error('email') input-error @enderror" placeholder="nama@email.com">
            @error('email')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="label-field">Password</label>
            <input type="password" id="password" name="password" required
                   class="input-field @error('password') input-error @enderror" placeholder="••••••••">
            @error('password')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-border bg-bg text-primary focus:ring-primary/40 focus:ring-offset-0">
                <span class="text-text-secondary">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-primary hover:underline text-xs font-medium">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full py-2.5">Masuk</button>
    </form>

    {{-- Link ke Halaman Daftar --}}
    <div class="mt-6 pt-6 border-t border-border text-center">
        <p class="text-sm text-text-secondary">
            Belum punya akun siswa?
            <a href="{{ route('register') }}" class="text-primary hover:underline font-bold ml-1">
                Daftar di sini
            </a>
        </p>
    </div>

    {{-- Akun Demo --}}
    <div class="mt-4 bg-bg border border-border rounded-lg p-3">
        <p class="text-[10px] font-bold text-text-muted uppercase tracking-wider mb-2">Akun Demo (Testing)</p>
        <div class="text-xs text-text-secondary space-y-1">
            <p>Admin: <span class="text-text-primary font-mono">admin@pinbuk.test</span></p>
            <p>Siswa: <span class="text-text-primary font-mono">siswa@pinbuk.test</span></p>
            <p>Pass: <span class="text-text-primary font-mono">password</span></p>
        </div>
    </div>

</x-guest-layout>