@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-layanan.css') }}">

<div class="al-header">
    <h1>Permintaan Penawaran</h1>
</div>

@if (session('success'))
    <div class="al-alert-success">{{ session('success') }}</div>
@endif

{{-- FILTER STATUS --}}
<div class="al-chips">

    <a href="{{ route('admin.penawaran.index', ['q' => $cari ?: null]) }}"
       class="al-chip {{ !$status ? 'active' : '' }}">
        Semua ({{ $jumlah->sum() }})
    </a>

    @foreach (\App\Models\PermintaanPenawaran::STATUS as $kode => $label)
        <a href="{{ route('admin.penawaran.index', ['status' => $kode, 'q' => $cari ?: null]) }}"
           class="al-chip {{ $status === $kode ? 'active' : '' }}">
            {{ $label }} ({{ $jumlah[$kode] ?? 0 }})
        </a>
    @endforeach

</div>

{{-- PENCARIAN --}}
<form class="al-search" method="GET" action="{{ route('admin.penawaran.index') }}">

    @if ($status)
        <input type="hidden" name="status" value="{{ $status }}">
    @endif

    <input type="text" name="q" value="{{ $cari }}"
           placeholder="Cari nomor, nama, perusahaan, atau email">

    <button type="submit" class="al-btn al-btn-dark">Cari</button>

</form>

<div class="al-table-card">

    <table class="al-table">

        <thead>
            <tr>
                <th>No. Permintaan</th>
                <th>Pemohon</th>
                <th>Kebutuhan</th>
                <th>Jumlah</th>
                <th>Lokasi Kirim</th>
                <th>Status</th>
                <th>Diterima</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($permintaan as $item)
                <tr>

                    <td><strong>{{ $item->nomor_permintaan }}</strong></td>

                    <td>
                        {{ $item->nama_pemohon }}
                        <span class="al-sub">{{ $item->nama_perusahaan ?: '-' }}</span>
                    </td>

                    <td>
                        {{ $item->jenis_produk_label }}
                        <span class="al-sub">{{ $item->ringkasan_item }}</span>
                    </td>

                    <td>{{ number_format($item->jumlah, 0, ',', '.') }} pcs</td>

                    <td>{{ $item->lokasi_pengiriman }}</td>

                    <td>
                        @php [$bg, $fg] = $item->status_warna; @endphp
                        <span class="al-badge" style="background:{{ $bg }}; color:{{ $fg }};">
                            {{ $item->status_label }}
                        </span>
                    </td>

                    <td>{{ $item->created_at->format('d M Y') }}</td>

                    <td>
                        <a href="{{ route('admin.penawaran.show', $item->id_penawaran) }}"
                           class="al-btn al-btn-sm">
                            <i class="ri-eye-line"></i> Detail
                        </a>

                        <form action="{{ route('admin.penawaran.destroy', $item->id_penawaran) }}"
                              method="POST" style="display:inline-block;"
                              onsubmit="return confirm('Yakin hapus permintaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="al-btn al-btn-sm al-btn-red">Hapus</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="8" class="al-empty">Belum ada permintaan penawaran.</td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<div class="al-pager">
    {{ $permintaan->links('pagination::bootstrap-4') }}
</div>

@endsection
