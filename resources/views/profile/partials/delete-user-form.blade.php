<section x-data="{ showConfirm: false }">
    <button @click="showConfirm = true" class="btn-danger">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
        Hapus Akun Saya
    </button>

    {{-- Modal Konfirmasi --}}
    <div x-show="showConfirm"
         x-transition.opacity
         @keydown.escape.window="showConfirm = false"
         class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4"
         style="display: none;">

        <div @click.away="showConfirm = false"
             x-transition
             class="w-full max-w-md bg-bg-card border border-border rounded-xl p-6 animate-fade-in">

            <h3 class="text-lg font-semibold text-text-primary mb-2">Hapus Akun Permanen?</h3>
            <p class="text-sm text-text-secondary mb-5">
                Semua data akan dihapus permanen. Masukkan password untuk konfirmasi.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')

                <div>
                    <label for="password" class="label-field">Password <span class="text-danger">*</span></label>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Masukkan password kamu"
                           class="input-field @error('password', 'userDeletion') input-error @enderror">
                    @error('password', 'userDeletion')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="showConfirm = false" class="btn-ghost">Batal</button>
                    <button type="submit" class="btn-danger">Ya, Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</section>