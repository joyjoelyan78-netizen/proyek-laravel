@extends('layouts.frontend')

@section('content')

<link rel="stylesheet" href="/css/layanan-form.css">

@php
    $wa = preg_replace('/\D+/', '', (string) config('vesca.whatsapp'));

    $pesanWa = "Halo PT Vescarindo Utama, saya baru mengirim permintaan penawaran dengan nomor {$nomor}.";
@endphp

<section class="lf-page">

    <div class="lf-sukses">

        <div class="lf-sukses-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>Permintaan Terkirim</h1>

        <p>
            Terima kasih. Permintaan penawaran Anda sudah kami terima
            dan akan ditinjau oleh tim kami.
        </p>

        <div class="lf-nomor">
            <span>Nomor permintaan Anda</span>
            <strong>{{ $nomor }}</strong>
        </div>

        @if (session('email_success'))
            <p>Notifikasi permintaan penawaran berhasil dikirim ke tim kami.</p>
        @endif

        @if (session('email_warning'))
            <p role="alert">{{ session('email_warning') }}</p>
        @endif

        <p>
            Simpan nomor ini untuk memudahkan Anda saat menghubungi kami.
            Surat penawaran resmi akan dikirim melalui email atau WhatsApp
            dengan estimasi {{ config('vesca.sla_respon') }}.
        </p>

        <div class="lf-actions">

            @if ($wa)
                <a class="lf-btn lf-btn-wa"
                   href="https://wa.me/{{ $wa }}?text={{ rawurlencode($pesanWa) }}"
                   target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                </a>
            @endif

            <a class="lf-btn lf-btn-outline" href="{{ route('produk') }}">
                Lihat Produk
            </a>

            <a class="lf-btn" href="/">
                Kembali ke Beranda
            </a>

        </div>

    </div>

</section>

@endsection
