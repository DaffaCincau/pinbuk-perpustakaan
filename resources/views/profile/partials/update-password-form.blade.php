<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="label-field">Password Saat Ini <span class="text-danger">*</span></label>
            <input type="password"
                   id="update_password_current_password"
                   name="current_password"
                   autocomplete="current-password"
                   class="input-field @error('current_password', 'updatePassword') input-error @enderror">
            @error('current_password', 'updatePassword')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="update_password_password" class="label-field">Password Baru <span class="text-danger">*</span></label>
            <input type="password"
                   id="update_password_password"
                   name="password"
                   autocomplete="new-password"
                   class="input-field @error('password', 'updatePassword') input-error @enderror">
            @error('password', 'updatePassword')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="label-field">Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password"
                   id="update_password_password_confirmation"
                   name="password_confirmation"
                   autocomplete="new-password"
                   class="input-field @error('password_confirmation', 'updatePassword') input-error @enderror">
            @error('password_confirmation', 'updatePassword')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-xs text-success">
                    ✓ Password berhasil diubah
                </p>
            @endif
        </div>
    </form>
</section>