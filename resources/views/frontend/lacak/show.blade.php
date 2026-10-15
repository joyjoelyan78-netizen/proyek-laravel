<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Status Pesanan</title>

    <link rel="stylesheet"
          href="{{ asset('css/tracking.css') }}">

</head>
<body>

<div class="tracking-container">

    <div class="tracking-page">

        {{-- BACK --}}
        <div class="tracking-back">
            <a href="{{ route('lacak-pesanan.index') }}"
               class="btn-back">

                ← Kembali

            </a>
        </div>

        {{-- HEADER --}}
        <div class="tracking-header">

            {{-- LEFT --}}
            <div class="header-left">

                <h1>
                    {{ $pesanan->nomor_invoice }}
                </h1>

                <p>
                    Estimasi selesai :
                    {{ $pesanan->estimasi_selesai }}
                </p>

            </div>

            {{-- RIGHT --}}
            <div class="header-right">

                <div class="progress-circle">

                    <div class="circle-inner">

                        {{ $progress }}%

                    </div>

                </div>

            </div>

        </div>

        {{-- SUMMARY --}}
        <div class="tracking-summary">

            <div class="summary-card">

                <span>Tanggal Order</span>

                <strong>
                    {{ date('d-m-Y', strtotime($pesanan->created_at)) }}
                </strong>

            </div>

            <div class="summary-card">

                <span>Estimasi</span>

                <strong>
                    {{ $pesanan->estimasi_selesai }}
                </strong>

            </div>

            <div class="summary-card">

                <span>Progress</span>

                <strong>
                    {{ $progress }}%
                </strong>

            </div>

        </div>

        {{-- TIMELINE --}}
        <div class="timeline-wrapper">

            <h2>
                Tahapan Produksi
            </h2>

            <div class="timeline">

                @foreach($statusTracking as $status)

                    @php

                        $tracking =
                            $trackingPesanan[
                                $status->id_status_tracking
                            ] ?? null;

                        $statusValue =
                            $tracking->status ?? 'menunggu';

                    @endphp

                    <div class="timeline-item">

                        {{-- DOT --}}
                        <div class="timeline-dot

                            @if($statusValue == 'selesai')
                                done
                            @elseif($statusValue == 'berlangsung')
                                active
                            @else
                                pending
                            @endif

                        ">
                        </div>

                        {{-- CONTENT --}}
                        <div class="timeline-content

                            @if($statusValue == 'selesai')
                                done-card
                            @elseif($statusValue == 'berlangsung')
                                active-card
                            @else
                                pending-card
                            @endif

                        ">

                            <div class="timeline-top">

                                <h4>
                                    {{ $status->nama_status }}
                                </h4>

                                <span>
                                    {{ ucfirst($statusValue) }}
                                </span>

                            </div>

                            <p>

                                {{ $tracking->deskripsi
                                    ?? 'Menunggu proses berikutnya' }}

                            </p>

                            @if($tracking)

                                <small>

                                    {{ $tracking->created_at }}

                                </small>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- HELP --}}
        <div class="help-box">

            <div>

                <h4>
                    Butuh bantuan?
                </h4>

                <p>
                    +62 812 0000 0000
                </p>

            </div>

            <a href="https://wa.me/628120000000"
               target="_blank"
               class="btn-chat">

                Chat

            </a>

        </div>

        {{-- SEARCH AGAIN --}}
        <a href="{{ route('lacak-pesanan.index') }}"
           class="btn-search-again">

            Cari Invoice Lain

        </a>

    </div>

</div>

</body>
</html>