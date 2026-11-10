<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="label-field">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   required
                   autofocus
                   autocomplete="name"
                   class="input-field @error('name') input-error @enderror">
            @error('name')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="label-field">Email <span class="text-danger">*</span></label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   required
                   autocomplete="username"
                   class="input-field @error('email') input-error @enderror">
            @error('email')<p class="error-text">{{ $message }}</p>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 rounded-lg bg-warning/10 border border-warning/30">
                    <p class="text-xs text-warning">
                        Email kamu belum diverifikasi.
                        <button form="send-verification" class="underline font-semibold hover:no-underline">
                            Klik di sini untuk kirim ulang link verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-xs text-success mt-2">
                            Link verifikasi baru telah dikirim ke email kamu.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if ($user->isSiswa())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nis" class="label-field">NIS</label>
                    <input type="text"
                           id="nis"
                           name="nis"
                           value="{{ old('nis', $user->nis) }}"
                           class="input-field @error('nis') input-error @enderror">
                    @error('nis')<p class="error-text">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="phone" class="label-field">Nomor HP</label>
                    <input type="text"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           class="input-field @error('phone') input-error @enderror">
                    @error('phone')<p class="error-text">{{ $message }}</p>@enderror
                </div>
            </div>
        @endif

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }"
                   x-show="show"
                   x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-xs text-success">
                    ✓ Tersimpan
                </p>
            @endif
        </div>
    </form>
</section>