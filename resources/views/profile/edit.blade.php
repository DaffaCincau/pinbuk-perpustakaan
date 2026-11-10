@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.siswa')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun dan keamanan')

@section('content')
<div class="max-w-3xl space-y-4">

    {{-- Update Profile Information --}}
    <div class="card card-pad">
        <h2 class="text-base font-semibold text-text-primary mb-1">Informasi Profil</h2>
        <p class="text-xs text-text-secondary mb-5">
            Perbarui nama, email, NIS, dan nomor HP kamu.
        </p>

        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Update Password --}}
    <div class="card card-pad">
        <h2 class="text-base font-semibold text-text-primary mb-1">Ubah Password</h2>
        <p class="text-xs text-text-secondary mb-5">
            Gunakan password yang panjang dan unik untuk keamanan akun.
        </p>

        @include('profile.partials.update-password-form')
    </div>

    {{-- Delete Account --}}
    <div class="card card-pad border-danger/30">
        <h2 class="text-base font-semibold text-danger mb-1">Hapus Akun</h2>
        <p class="text-xs text-text-secondary mb-5">
            Setelah akun dihapus, semua data akan hilang permanen. Tindakan ini tidak bisa dibatalkan.
        </p>

        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection