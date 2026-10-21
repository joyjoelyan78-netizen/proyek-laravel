@extends('layouts.frontend')

@section('content')

<link rel="stylesheet" href="/css/layanan-form.css">

@php
    $wa = preg_replace('/\D+/', '', (string) config('vesca.whatsapp'));

    $pesanWa = "Halo PT Vescarindo Utama, saya baru mengirim pertanyaan konsultasi teknis dengan nomor {$nomor}.";
@endphp

<section class="lf-page">

    <div class="lf-sukses">

        <div class="lf-sukses-icon">
            <i class="fas fa-check"></i>
        </div>

        <h1>Pertanyaan Terkirim</h1>

        <p>
            Terima kasih. Pertanyaan Anda sudah kami terima dan akan
            dijawab oleh tim teknis kami.
        </p>

        <div class="lf-nomor">
            <span>Nomor konsultasi Anda</span>
            <strong>{{ $nomor }}</strong>
        </div>
 
        @if (session('email_success'))
            <p class="lf-email-success">
                <i class="fas fa-check-circle"></i>
                Notifikasi konsultasi berhasil dikirim ke tim kami melalui email.
            </p>
        @endif

        @if (session('email_warning'))
            <p class="lf-email-warning" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('email_warning') }}
            </p>
        @endif


        <p>
            Jawaban akan dikirim melalui email atau WhatsApp dengan estimasi
            {{ config('vesca.sla_respon') }}. Jika Anda sudah siap meminta harga,
            silakan lanjut ke formulir penawaran.
        </p>

        <div class="lf-actions">

            @if ($wa)
                <a class="lf-btn lf-btn-wa"
                   href="https://wa.me/{{ $wa }}?text={{ rawurlencode($pesanWa) }}"
                   target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                </a>
            @endif

            <a class="lf-btn lf-btn-outline" href="{{ route('penawaran.index') }}">
                Minta Penawaran Resmi
            </a>

            <a class="lf-btn" href="/">
                Kembali ke Beranda
            </a>

        </div>

    </div>

</section>

@endsection
