@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-layanan.css') }}">

<div class="al-header">
    <h1>Konsultasi Teknis</h1>
</div>

@if (session('success'))
    <div class="al-alert-success">{{ session('success') }}</div>
@endif

{{-- FILTER STATUS --}}
<div class="al-chips">

    <a href="{{ route('admin.konsultasi.index', ['q' => $cari ?: null]) }}"
       class="al-chip {{ !$status ? 'active' : '' }}">
        Semua ({{ $jumlah->sum() }})
    </a>

    @foreach (\App\Models\KonsultasiTeknis::STATUS as $kode => $label)
        <a href="{{ route('admin.konsultasi.index', ['status' => $kode, 'q' => $cari ?: null]) }}"
           class="al-chip {{ $status === $kode ? 'active' : '' }}">
            {{ $label }} ({{ $jumlah[$kode] ?? 0 }})
        </a>
    @endforeach

</div>

{{-- PENCARIAN --}}
<form class="al-search" method="GET" action="{{ route('admin.konsultasi.index') }}">

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
                <th>No. Konsultasi</th>
                <th>Pengirim</th>
                <th>Kapal</th>
                <th>Kondisi Air</th>
                <th>Status</th>
                <th>Diterima</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($konsultasi as $item)
                <tr>

                    <td><strong>{{ $item->nomor_konsultasi }}</strong></td>

                    <td>
                        {{ $item->nama_pengirim }}
                        <span class="al-sub">{{ $item->nama_perusahaan ?: '-' }}</span>
                    </td>

                    <td>
                        {{ $item->jenis_kapal }}
                        @if ($item->ukuran_kapal)
                            <span class="al-sub">{{ $item->ukuran_kapal }}</span>
                        @endif
                    </td>

                    <td>{{ $item->kondisi_air_label }}</td>

                    <td>
                        @php [$bg, $fg] = $item->status_warna; @endphp
                        <span class="al-badge" style="background:{{ $bg }}; color:{{ $fg }};">
                            {{ $item->status_label }}
                        </span>
                    </td>

                    <td>{{ $item->created_at->format('d M Y') }}</td>

                    <td>
                        <a href="{{ route('admin.konsultasi.show', $item->id_konsultasi) }}"
                           class="al-btn al-btn-sm">
                            <i class="ri-eye-line"></i> Detail
                        </a>

                        <form action="{{ route('admin.konsultasi.destroy', $item->id_konsultasi) }}"
                              method="POST" style="display:inline-block;"
                              onsubmit="return confirm('Yakin hapus konsultasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="al-btn al-btn-sm al-btn-red">Hapus</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" class="al-empty">Belum ada pertanyaan konsultasi.</td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<div class="al-pager">
    {{ $konsultasi->links('pagination::bootstrap-4') }}
</div>

@endsection
