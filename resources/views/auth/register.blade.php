<x-guest-layout :title="'Daftar'">

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
        <h2 class="text-xl font-bold text-text-primary">Buat Akun Baru ✨</h2>
        <p class="text-sm text-text-secondary mt-1">Daftar untuk mulai meminjam buku.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="label-field">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="input-field @error('name') input-error @enderror" placeholder="Nama lengkap kamu">
            @error('name')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="nis" class="label-field">NIS</label>
            <input type="text" id="nis" name="nis" value="{{ old('nis') }}"
                   class="input-field @error('nis') input-error @enderror" placeholder="Nomor Induk Siswa (opsional)">
            @error('nis')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="label-field">Email <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="input-field @error('email') input-error @enderror" placeholder="nama@email.com">
            @error('email')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="phone" class="label-field">Nomor HP</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                   class="input-field @error('phone') input-error @enderror" placeholder="08xxxxxxxxxx (opsional)">
            @error('phone')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="label-field">Password <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password" required autocomplete="new-password"
                   class="input-field @error('password') input-error @enderror" placeholder="Minimal 8 karakter">
            @error('password')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="label-field">Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                   class="input-field" placeholder="Ketik ulang password">
        </div>

        <button type="submit" class="btn-primary w-full py-2.5 mt-2">Daftar Sekarang</button>
    </form>

    {{-- Link ke Halaman Login --}}
    <div class="mt-6 pt-6 border-t border-border text-center">
        <p class="text-sm text-text-secondary">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary hover:underline font-bold ml-1">
                Masuk di sini
            </a>
        </p>
    </div>

</x-guest-layout>