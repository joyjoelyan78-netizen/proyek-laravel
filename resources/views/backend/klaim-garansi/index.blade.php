@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/klaim-garansi.css') }}">

<div class="page-header">
    <h1>Klaim Garansi</h1>
</div>

{{-- Alert sukses --}}
@if(session('success'))
<div style="background:#d4edda; color:#155724; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
    {{ session('success') }}
</div>
@endif

{{-- Summary badge --}}
@php
    $totalPending  = $klaim->where('status_klaim', 'pending')->count();
    $totalSelesai  = $klaim->where('status_klaim', 'selesai')->count();
    $totalDitolak  = $klaim->where('status_klaim', 'ditolak')->count();
@endphp

<div style="display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap;">

    <div style="background:#fff3cd; color:#856404; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600;">
        <i class="ri-time-line"></i> Pending: {{ $totalPending }}
    </div>

    <div style="background:#d4edda; color:#155724; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600;">
        <i class="ri-check-line"></i> Diterima: {{ $totalSelesai }}
    </div>

    <div style="background:#f8d7da; color:#721c24; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600;">
        <i class="ri-close-line"></i> Ditolak: {{ $totalDitolak }}
    </div>

</div>

<div class="card-table">

    <table>

        <thead>
            <tr>
                <th>Nama Pembeli</th>
                <th>Produk</th>
                <th>Serial</th>
                <th>No. Tiket</th>
                <th>Status</th>
                <th>Tanggal Klaim</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($klaim as $item)
            <tr>

                <td>{{ $item->nama_pembeli ?? $item->customer->nama_customer ?? '-' }}</td>

                <td>{{ $item->serial->produk->nama_produk ?? $item->produk->nama_produk ?? '-' }}</td>

                <td>{{ $item->serial->kode_unik ?? '-' }}</td>

                <td>{{ $item->tiket->nomor_tiket ?? '-' }}</td>

                <td>
                    @if($item->status_klaim === 'pending')
                        <span style="background:#fff3cd; color:#856404; padding:3px 10px; border-radius:999px; font-size:12px; font-weight:600;">
                            Pending
                        </span>
                    @elseif($item->status_klaim === 'selesai')
                        <span style="background:#d4edda; color:#155724; padding:3px 10px; border-radius:999px; font-size:12px; font-weight:600;">
                            Diterima
                        </span>
                    @elseif($item->status_klaim === 'ditolak')
                        <span style="background:#f8d7da; color:#721c24; padding:3px 10px; border-radius:999px; font-size:12px; font-weight:600;">
                            Ditolak
                        </span>
                    @else
                        <span style="background:#e2e3e5; color:#383d41; padding:3px 10px; border-radius:999px; font-size:12px; font-weight:600;">
                            {{ $item->status_klaim }}
                        </span>
                    @endif
                </td>

                <td>{{ \Carbon\Carbon::parse($item->tanggal_klaim ?? $item->tanggal_pengajuan)->format('d M Y') }}</td>

                <td>
                    <a href="{{ route('klaim-garansi.detail', $item->id_klaim) }}" style="
                        background:#3498db;
                        color:#fff;
                        padding:5px 14px;
                        border-radius:6px;
                        font-size:12px;
                        text-decoration:none;
                        display:inline-block;
                    ">
                        <i class="ri-eye-line"></i> Detail
                    </a>

                    <form action="{{ route('klaim-garansi.destroy', $item->id_klaim) }}"
                          method="POST"
                          style="display:inline-block;"
                          onsubmit="return confirm('Yakin hapus klaim ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="
                            background:#e74c3c;
                            color:#fff;
                            padding:5px 14px;
                            border-radius:6px;
                            font-size:12px;
                            border:none;
                            cursor:pointer;
                        ">
                            <i class="ri-delete-bin-line"></i> Hapus
                        </button>
                    </form>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#999; padding:24px;">
                    Belum ada data klaim garansi.
                </td>
            </tr>
            @endforelse

        </tbody>

    </table>

</div>

@endsection