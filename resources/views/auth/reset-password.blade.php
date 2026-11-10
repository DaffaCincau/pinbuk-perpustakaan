<x-guest-layout :title="'Reset Password'">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-text-primary">Reset Password 🔒</h1>
        <p class="text-sm text-text-secondary mt-1">
            Buat password baru untuk akun kamu.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div>
            <label for="email" class="label-field">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $request->email) }}"
                   required
                   autofocus
                   autocomplete="username"
                   class="input-field @error('email') input-error @enderror">
            @error('email')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        {{-- Password Baru --}}
        <div>
            <label for="password" class="label-field">Password Baru</label>
            <div class="relative" x-data="{ show: false }">
                <input :type="show ? 'text' : 'password'"
                       id="password"
                       name="password"
                       placeholder="Minimal 8 karakter"
                       required
                       autocomplete="new-password"
                       class="input-field pr-10 @error('password') input-error @enderror">
                <button type="button"
                        @click="show = !show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-text-primary">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        {{-- Konfirmasi --}}
        <div>
            <label for="password_confirmation" class="label-field">Konfirmasi Password</label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   placeholder="Ketik ulang password baru"
                   required
                   autocomplete="new-password"
                   class="input-field">
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            Reset Password
        </button>
    </form>

</x-guest-layout>