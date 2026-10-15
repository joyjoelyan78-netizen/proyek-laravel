@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-layanan.css') }}">

<div class="al-header">

    <h1>Detail Konsultasi Teknis</h1>

    <a href="{{ route('admin.konsultasi.index') }}" class="al-btn al-btn-gray">&larr; Kembali</a>

</div>

@if (session('success'))
    <div class="al-alert-success">{{ session('success') }}</div>
@endif

<div class="al-detail">

    {{-- ================= KIRI: DATA KONSULTASI ================= --}}
    <div>

        <div class="al-box">

            <h3><i class="ri-user-line"></i> Pengirim</h3>

            <div class="al-row"><span>No. Konsultasi</span><strong>{{ $konsultasi->nomor_konsultasi }}</strong></div>
            <div class="al-row"><span>Nama</span><strong>{{ $konsultasi->nama_pengirim }}</strong></div>
            <div class="al-row"><span>Perusahaan</span><strong>{{ $konsultasi->nama_perusahaan ?: '-' }}</strong></div>
            <div class="al-row"><span>Email</span><strong>{{ $konsultasi->email }}</strong></div>
            <div class="al-row"><span>Telepon / WhatsApp</span><strong>{{ $konsultasi->nomor_telepon }}</strong></div>
            <div class="al-row"><span>Diterima</span><strong>{{ $konsultasi->created_at->format('d M Y, H:i') }}</strong></div>

        </div>

        <div class="al-box">

            <h3><i class="ri-ship-line"></i> Kondisi Kapal</h3>

            <div class="al-row"><span>Jenis Kapal</span><strong>{{ $konsultasi->jenis_kapal }}</strong></div>
            <div class="al-row"><span>Ukuran Kapal</span><strong>{{ $konsultasi->ukuran_kapal ?: '-' }}</strong></div>
            <div class="al-row"><span>Bagian Dilindungi</span><strong>{{ $konsultasi->bagian_dilindungi ?: '-' }}</strong></div>
            <div class="al-row"><span>Kondisi Air</span><strong>{{ $konsultasi->kondisi_air_label }}</strong></div>
            <div class="al-row"><span>Seri Diminati</span><strong>{{ $konsultasi->produk_diminati_label }}</strong></div>

        </div>

        <div class="al-box">

            <h3><i class="ri-question-answer-line"></i> Pertanyaan</h3>

            <div class="al-text">{{ $konsultasi->pertanyaan }}</div>

        </div>

    </div>


    {{-- ================= KANAN: TINDAKAN ================= --}}
    <div>

        <div class="al-box">

            <h3><i class="ri-send-plane-line"></i> Hubungi Pengirim</h3>

            <div class="al-contact">

                <a class="al-btn al-btn-dark"
                   href="mailto:{{ $konsultasi->email }}?subject={{ rawurlencode('Konsultasi ' . $konsultasi->nomor_konsultasi . ' - PT Vescarindo Utama') }}">
                    <i class="ri-mail-line"></i> Email
                </a>

                <a class="al-btn al-btn-green"
                   href="{{ $konsultasi->whatsapp_link }}" target="_blank" rel="noopener">
                    <i class="ri-whatsapp-line"></i> WhatsApp
                </a>

            </div>

            <span class="al-hint" style="display:block;margin-top:10px;font-size:12px;color:#94a3b8;">
                Jawaban dikirim lewat Email atau WhatsApp. Salin jawabannya ke kolom di bawah sebagai arsip.
            </span>

        </div>

        <div class="al-box">

            <h3><i class="ri-chat-check-line"></i> Balasan &amp; Status</h3>

            @if ($errors->any())
                <div class="al-alert-error">{{ $errors->first() }}</div>
            @endif

            <form class="al-form"
                  action="{{ route('admin.konsultasi.update', $konsultasi->id_konsultasi) }}"
                  method="POST">

                @csrf
                @method('PATCH')

                <label for="status">Status</label>
                <select id="status" name="status">
                    @foreach (\App\Models\KonsultasiTeknis::STATUS as $kode => $label)
                        <option value="{{ $kode }}" @selected(old('status', $konsultasi->status) === $kode)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <label for="balasan_admin">Catatan Balasan</label>
                <textarea id="balasan_admin" name="balasan_admin" rows="7"
                          placeholder="Tuliskan ringkasan jawaban atau rekomendasi yang diberikan">{{ old('balasan_admin', $konsultasi->balasan_admin) }}</textarea>
                <span class="al-hint">Catatan ini tersimpan di sistem sebagai arsip, tidak otomatis terkirim ke pengirim.</span>

                @if ($konsultasi->dibalas_pada)
                    <span class="al-hint">
                        Dibalas pada {{ $konsultasi->dibalas_pada->format('d M Y, H:i') }}
                        @if ($konsultasi->userBalas)
                            oleh {{ $konsultasi->userBalas->nama }}
                        @endif
                        .
                    </span>
                @endif

                <div style="margin-top:18px;">
                    <button type="submit" class="al-btn al-btn-dark">Simpan</button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection
