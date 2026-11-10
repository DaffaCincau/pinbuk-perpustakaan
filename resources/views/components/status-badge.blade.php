@props(['status'])

@php
    use App\Enums\StatusPeminjaman;

    $statusEnum = $status instanceof StatusPeminjaman
        ? $status
        : StatusPeminjaman::tryFrom($status);

    $label = $statusEnum?->label() ?? ucfirst($status);
    
    // Warna dot indikator (Minimalis, tanpa background nyala)
    $dotColor = match($statusEnum) {
        StatusPeminjaman::MENUNGGU     => 'bg-warning',
        StatusPeminjaman::DISETUJUI    => 'bg-primary',
        StatusPeminjaman::DIPINJAM     => 'bg-accent',
        StatusPeminjaman::DIKEMBALIKAN => 'bg-success',
        StatusPeminjaman::DITOLAK,
        StatusPeminjaman::TERLAMBAT    => 'bg-danger',
        default                        => 'bg-text-muted',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 px-2.5 py-1 rounded-md text-xs font-medium bg-white border border-border text-text-secondary shadow-sm']) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    {{ $label }}
</span>