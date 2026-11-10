<x-guest-layout :title="'Lupa Password'">

    {{-- Heading --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-text-primary">Lupa Password? 🔑</h1>
        <p class="text-sm text-text-secondary mt-1">
            Masukkan email kamu, kami akan kirim link untuk reset password.
        </p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 alert alert-success">
            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="label-field">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   required
                   autofocus
                   class="input-field @error('email') input-error @enderror">
            @error('email')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Kirim Link Reset
        </button>
    </form>

    {{-- Back to login --}}
    <div class="mt-6 pt-6 border-t border-border text-center">
        <a href="{{ route('login') }}" class="text-sm text-text-secondary hover:text-text-primary transition-colors inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke halaman masuk
        </a>
    </div>

</x-guest-layout>