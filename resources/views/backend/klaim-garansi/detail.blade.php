@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/klaim-garansi.css') }}">

<div class="dashboard-header">
    <div>
        <h1>Detail Klaim Garansi</h1>
    </div>
    <a href="/admin/klaim-garansi" style="
        background:#6c757d;
        color:#fff;
        padding:8px 16px;
        border-radius:8px;
        text-decoration:none;
        font-size:13px;
    ">← Kembali</a>
</div>

{{-- Alert sukses --}}
@if(session('success'))
<div style="background:#d4edda; color:#155724; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
    {{ session('success') }}
</div>
@endif

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

    {{-- INFO KLAIM --}}
    <div class="dashboard-box">
        <div class="box-header">
            <h3><i class="ri-file-list-3-line"></i> Informasi Klaim</h3>
        </div>

        <div class="info-user">
            <div class="info-item">
                <span>Status Klaim</span>
                <strong>
                @if($klaim->status_klaim === 'pending')

                    <span style="
                        background:#fff3cd;
                        color:#856404;
                        padding:3px 10px;
                        border-radius:999px;
                        font-size:12px;
                    ">
                        Pending
                    </span>

                @elseif($klaim->status_klaim === 'diterima')

                    <span style="
                        background:#d1ecf1;
                        color:#0c5460;
                        padding:3px 10px;
                        border-radius:999px;
                        font-size:12px;
                        font-weight:600;
                    ">
                        Diterima
                    </span>

                @elseif($klaim->status_klaim === 'diproses')

                    <span style="
                        background:#cce5ff;
                        color:#004085;
                        padding:3px 10px;
                        border-radius:999px;
                        font-size:12px;
                        font-weight:600;
                    ">
                        Diproses Teknisi
                    </span>

                @elseif($klaim->status_klaim === 'selesai')

                    <span style="
                        background:#d4edda;
                        color:#155724;
                        padding:3px 10px;
                        border-radius:999px;
                        font-size:12px;
                        font-weight:600;
                    ">
                        Selesai
                    </span>

                @elseif($klaim->status_klaim === 'ditolak')

                    <span style="
                        background:#f8d7da;
                        color:#721c24;
                        padding:3px 10px;
                        border-radius:999px;
                        font-size:12px;
                        font-weight:600;
                    ">
                        Ditolak
                    </span>

                @else

                    <span style="
                        background:#e2e3e5;
                        color:#383d41;
                        padding:3px 10px;
                        border-radius:999px;
                        font-size:12px;
                    ">
                        {{ $klaim->status_klaim }}
                    </span>

                @endif
                </strong>
            </div>

            <div class="info-item">
                <span>Nomor Tiket</span>
                <strong>{{ $klaim->tiket->nomor_tiket ?? '-' }}</strong>
            </div>

            <div class="info-item">
                <span>Tanggal Klaim</span>
                <strong>{{ \Carbon\Carbon::parse($klaim->tanggal_klaim)->format('d M Y, H:i') }}</strong>
            </div>

            <div class="info-item">
                <span>Judul Keluhan</span>
                <strong>{{ $klaim->judul_keluhan }}</strong>
            </div>

            <div class="info-item">
                <span>Deskripsi Keluhan</span>
                <strong>{{ $klaim->deskripsi_keluhan }}</strong>
            </div>

            @if($klaim->alasan_tolak)
            <div class="info-item">
                <span>Alasan Ditolak</span>
                <strong style="color:#e74c3c;">{{ $klaim->alasan_tolak }}</strong>
            </div>
            @endif
        </div>
    </div>

    {{-- INFO CUSTOMER --}}
    <div class="dashboard-box">
        <div class="box-header">
            <h3><i class="ri-user-line"></i> Informasi Customer</h3>
        </div>

        <div class="info-user">
            <div class="info-item">
                <span>Nama Pembeli</span>
                <strong>{{ $klaim->nama_pembeli }}</strong>
            </div>

            <div class="info-item">
                <span>Email</span>
                <strong>{{ $klaim->email }}</strong>
            </div>

            <div class="info-item">
                <span>Nomor Telepon</span>
                <strong>{{ $klaim->nomor_telepon }}</strong>
            </div>
        </div>
    </div>

    {{-- INFO PRODUK --}}
    <div class="dashboard-box">
        <div class="box-header">
            <h3><i class="ri-box-3-line"></i> Informasi Produk</h3>
        </div>

        <div class="info-user">
            <div class="info-item">
                <span>Nama Produk</span>
                <strong>{{ $klaim->serial->produk->nama_produk ?? '-' }}</strong>
            </div>

            <div class="info-item">
                <span>Kode Unik / Serial</span>
                <strong>{{ $klaim->serial->kode_unik ?? '-' }}</strong>
            </div>

            <div class="info-item">
                <span>Status Garansi</span>
                <strong>{{ $klaim->serial->status_garansi ?? '-' }}</strong>
            </div>
        </div>
    </div>

    {{-- FOTO BUKTI --}}
    <div class="dashboard-box">
        <div class="box-header">
            <h3><i class="ri-image-line"></i> Foto Bukti</h3>
        </div>

        @if($klaim->uploadFoto && $klaim->uploadFoto->file_foto)
            <img src="{{ asset('storage/' . $klaim->uploadFoto->file_foto) }}"
                 alt="Foto Bukti"
                 style="width:100%; max-height:300px; object-fit:contain; border-radius:8px; border:1px solid #eee;">
        @else
            <p style="color:#999; font-size:13px;">Tidak ada foto bukti.</p>
        @endif
    </div>

</div>

{{-- TOMBOL TERIMA / TOLAK — hanya tampil jika masih pending --}}
@if($klaim->status_klaim === 'pending')
<div style="display:flex; gap:16px; margin-top:24px;">

    {{-- TOMBOL TERIMA --}}
    <form action="{{ route('klaim-garansi.terima', $klaim->id_klaim) }}" method="POST"
          onsubmit="return confirm('Yakin ingin menerima klaim ini?')">
        @csrf
        @method('PATCH')
        <button type="submit" style="
            background:#27ae60;
            color:#fff;
            padding:10px 24px;
            border:none;
            border-radius:8px;
            font-size:14px;
            cursor:pointer;
        ">
            <i class="ri-check-line"></i> Jadwalkan Teknisi
        </button>
    </form>

    {{-- TOMBOL TOLAK — buka modal --}}
    <button onclick="document.getElementById('modal-tolak').style.display='flex'" style="
        background:#e74c3c;
        color:#fff;
        padding:10px 24px;
        border:none;
        border-radius:8px;
        font-size:14px;
        cursor:pointer;
    ">
        <i class="ri-close-line"></i> Tolak Klaim
    </button>

</div>

{{-- MODAL TOLAK --}}
<div id="modal-tolak" style="
    display:none;
    position:fixed; inset:0;
    background:rgba(0,0,0,0.5);
    z-index:9999;
    align-items:center;
    justify-content:center;
">
    <div style="background:#fff; border-radius:12px; padding:28px; width:460px; max-width:90%;">
        <h3 style="margin-bottom:16px;">Alasan Penolakan</h3>

        <form action="{{ route('klaim-garansi.tolak', $klaim->id_klaim) }}" method="POST">
            @csrf
            @method('PATCH')

            <textarea name="alasan_tolak" rows="4" required placeholder="Tulis alasan penolakan..." style="
                width:100%; padding:10px; border:1px solid #ddd;
                border-radius:8px; font-size:13px; resize:vertical;
                box-sizing:border-box;
            "></textarea>

            <div style="display:flex; gap:12px; margin-top:16px; justify-content:flex-end;">
                <button type="button"
                        onclick="document.getElementById('modal-tolak').style.display='none'"
                        style="
                            background:#6c757d; color:#fff;
                            padding:8px 20px; border:none;
                            border-radius:8px; cursor:pointer;
                        ">Batal</button>

                <button type="submit" style="
                    background:#e74c3c; color:#fff;
                    padding:8px 20px; border:none;
                    border-radius:8px; cursor:pointer;
                ">Tolak Klaim</button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection