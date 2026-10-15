@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/verifikasi-garansi.css') }}">

<div class="page-header">

    <h1>Verifikasi Garansi</h1>

    <a href="{{ route('verifikasi-garansi.create') }}"
       class="btn-primary">

        + Tambah Verifikasi

    </a>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>Customer</th>
                <th>Produk</th>
                <th>Teknisi</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Verifier</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($verifikasi as $item)

                <tr>

                    <td>
                        {{ $item->klaim->customer->nama_customer ?? '-' }}
                    </td>

                    <td>
                        {{ $item->klaim->produk->nama_produk ?? '-' }}
                    </td>

                    <td>
                        {{ $item->teknisi->nama_teknisi ?? '-' }}
                    </td>

                    <td>

                    @if($item->status_verifikasi == 'valid')

                        <span class="badge bg-success">
                            Valid
                        </span>

                    @elseif($item->status_verifikasi == 'tidak_valid')

                        <span class="badge bg-danger">
                            Tidak Valid
                        </span>

                    @else

                        <span class="badge bg-warning">
                            Menunggu Pemeriksaan
                        </span>

                    @endif

                    </td>

                    <td>

                        @if($item->tanggal_verifikasi)

                            {{ \Carbon\Carbon::parse($item->tanggal_verifikasi)->format('d M Y') }}

                        @else

                            -

                        @endif

                    </td>

                    <td>
                        {{ $item->user->nama ?? '-' }}
                    </td>

                    <td>

                        <div class="action-buttons">

                            <a href="{{ route('verifikasi-garansi.edit', $item->id_verifikasi) }}"
                               class="btn-edit">

                                Edit

                            </a>

                            <form action="{{ route('verifikasi-garansi.destroy', $item->id_verifikasi) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="btn-delete">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7">

                        Data verifikasi kosong

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection