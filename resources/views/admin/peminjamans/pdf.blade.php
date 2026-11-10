<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman — PINBUK</title>
    <style>
        @page {
            margin: 40px 30px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
        }

        /* Header */
        .header {
            border-bottom: 3px solid #3B82F6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-top {
            display: table;
            width: 100%;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 200px;
        }

        .logo-title {
            font-size: 22px;
            font-weight: bold;
            color: #0B0F19;
            letter-spacing: 0.5px;
        }

        .logo-subtitle {
            font-size: 11px;
            color: #64748B;
            margin-top: 2px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            color: #3B82F6;
        }

        .report-date {
            font-size: 9px;
            color: #64748B;
            margin-top: 2px;
        }

        /* Info Box */
        .info-box {
            background-color: #F1F5F9;
            border-left: 4px solid #3B82F6;
            padding: 10px 14px;
            margin-bottom: 15px;
            font-size: 9px;
        }

        .info-box table {
            width: 100%;
        }

        .info-box td {
            padding: 2px 0;
            vertical-align: top;
        }

        .info-label {
            color: #64748B;
            width: 100px;
            font-weight: 600;
        }

        .info-value {
            color: #1e293b;
            font-weight: 500;
        }

        /* Data Table */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data thead th {
            background-color: #3B82F6;
            color: #FFFFFF;
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid #2563eb;
        }

        table.data tbody td {
            padding: 7px 6px;
            font-size: 9px;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }

        table.data tbody tr:nth-child(even) {
            background-color: #F8FAFC;
        }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-menunggu     { background-color: #FEF3C7; color: #92400E; }
        .badge-disetujui    { background-color: #DBEAFE; color: #1E40AF; }
        .badge-dipinjam     { background-color: #CCFBF1; color: #115E59; }
        .badge-dikembalikan { background-color: #D1FAE5; color: #065F46; }
        .badge-terlambat    { background-color: #FEE2E2; color: #991B1B; }
        .badge-ditolak      { background-color: #FEE2E2; color: #991B1B; }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #cbd5e1;
            font-size: 8px;
            color: #64748B;
            text-align: center;
        }

        .summary {
            background-color: #F1F5F9;
            padding: 10px 14px;
            margin-top: 20px;
            font-size: 9px;
            border-radius: 4px;
        }

        .summary-row {
            padding: 3px 0;
        }

        .summary-label {
            font-weight: 600;
            color: #334155;
        }

        .summary-value {
            color: #0B0F19;
            font-weight: bold;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    {{-- ═══════════════════════════════════════ --}}
    {{-- HEADER --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="header">
        <div class="header-top">
            <div class="header-left">
                <div class="logo-title">PINBUK</div>
                <div class="logo-subtitle">Perpustakaan SMK Negeri 5 Surakarta</div>
            </div>
            <div class="header-right">
                <div class="report-title">Laporan Peminjaman</div>
                <div class="report-date">Dicetak: {{ $tanggalCetak }}</div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- INFO FILTER --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="info-box">
        <table>
            <tr>
                <td class="info-label">Status</td>
                <td class="info-value">: {{ $filterStatus }}</td>
                <td class="info-label">Total Data</td>
                <td class="info-value">: {{ $peminjamans->count() }} peminjaman</td>
            </tr>
            <tr>
                <td class="info-label">Kata Kunci</td>
                <td class="info-value">: {{ $filterKeyword }}</td>
                <td class="info-label">Periode</td>
                <td class="info-value">: {{ $periode }}</td>
            </tr>
        </table>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- DATA TABLE --}}
    {{-- ═══════════════════════════════════════ --}}
    <table class="data">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 70px;">Kode</th>
                <th>Nama Siswa</th>
                <th style="width: 60px;">NIS</th>
                <th>Judul Buku</th>
                <th style="width: 65px;">Tgl Pinjam</th>
                <th style="width: 65px;">Batas Kembali</th>
                <th style="width: 75px;">Status</th>
                <th style="width: 65px;" class="text-right">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjamans as $i => $p)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>PJM-{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->user->nis ?? '-' }}</td>
                    <td>{{ $p->buku->judul }}</td>
                    <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $p->status->value }}">
                            {{ $p->status->label() }}
                        </span>
                    </td>
                    <td class="text-right">
                        @if ($p->denda > 0)
                            Rp {{ number_format($p->denda, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px; color: #64748B;">
                        Tidak ada data peminjaman untuk filter ini
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ═══════════════════════════════════════ --}}
    {{-- SUMMARY --}}
    {{-- ═══════════════════════════════════════ --}}
    @if ($peminjamans->count() > 0)
        <div class="summary">
            <table style="width: 100%;">
                <tr>
                    <td class="summary-row">
                        <span class="summary-label">Total Peminjaman:</span>
                        <span class="summary-value">{{ $peminjamans->count() }}</span>
                    </td>
                    <td class="summary-row">
                        <span class="summary-label">Sedang Dipinjam:</span>
                        <span class="summary-value">
                            {{ $peminjamans->where('status', \App\Enums\StatusPeminjaman::DIPINJAM)->count() }}
                        </span>
                    </td>
                    <td class="summary-row">
                        <span class="summary-label">Total Denda:</span>
                        <span class="summary-value">
                            Rp {{ number_format($peminjamans->sum('denda'), 0, ',', '.') }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    @endif

    {{-- ═══════════════════════════════════════ --}}
    {{-- FOOTER --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="footer">
        Dokumen ini digenerate otomatis oleh PINBUK &mdash; Sistem Informasi Peminjaman Buku<br>
        Perpustakaan SMK Negeri 5 Surakarta &copy; {{ date('Y') }}
    </div>

</body>
</html>