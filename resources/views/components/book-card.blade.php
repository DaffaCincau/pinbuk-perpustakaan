@props(['buku', 'showStok' => true, 'href' => null])

@php
    $url = $href ?? (auth()->user()?->isAdmin()
        ? route('admin.bukus.show', $buku)
        : route('siswa.katalog.show', $buku));
@endphp

<a href="{{ $url }}" class="group bg-bg-card border border-border rounded-xl p-3 flex flex-col hover:border-primary/50 hover:shadow-md transition-all h-full relative">
    
    {{-- Cover Buku --}}
    <div class="aspect-[2/3] w-full rounded-md overflow-hidden bg-bg mb-4 relative border border-border">
        <img src="{{ $buku->cover_url }}"
             alt="{{ $buku->judul }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
             loading="lazy">
             
        @if ($showStok)
            <div class="absolute top-2 right-2">
                @if ($buku->stok > 0)
                    <span class="bg-white/90 text-text-primary border border-border text-[10px] font-bold px-2 py-1 rounded shadow-sm backdrop-blur-sm">
                        Stok: {{ $buku->stok }}
                    </span>
                @else
                    <span class="bg-danger text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                        Habis
                    </span>
                @endif
            </div>
        @endif
    </div>

    {{-- Info Buku --}}
    <h4 class="text-sm font-bold text-text-primary text-center line-clamp-2 leading-tight">
        {{ $buku->judul }}
    </h4>
    <p class="text-[10px] text-text-secondary text-center mt-1 mb-4 line-clamp-1">
        {{ $buku->pengarang }}
    </p>

    {{-- Tombol Detail --}}
    <div class="mt-auto flex justify-center">
        <span class="border border-border text-text-secondary text-xs px-6 py-1.5 rounded group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-colors shadow-sm">
            Detail
        </span>
    </div>
</a>