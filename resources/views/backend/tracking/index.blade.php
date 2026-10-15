@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/tracking-pesanan.css') }}">

<div class="page-header">

    <h1>Tracking Pesanan</h1>

    <a href="{{ route('tracking-pesanan.create') }}"
       class="btn-primary">

        + Tambah Tracking

    </a>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>Invoice</th>
                <th>Status Tracking</th>
                <th>Status</th>
                <th>PIC</th>
                <th>Tanggal Mulai</th>
                <th>Estimasi</th>
                <th width="180">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($tracking as $item)

            <tr>

                <td>

                    <strong>
                        {{ $item->pesanan->nomor_invoice }}
                    </strong>

                </td>

                <td>

                    {{ $item->statusTracking->nama_status }}

                </td>

                <td>

                    @if($item->status == 'selesai')

                        <span class="badge-active">
                            Selesai
                        </span>

                    @elseif($item->status == 'berlangsung')

                        <span class="badge-role">
                            Berlangsung
                        </span>

                    @else

                        <span class="badge-nonactive">
                            Menunggu
                        </span>

                    @endif

                </td>

                <td>

                    {{ $item->pic ?? '-' }}

                </td>

                <td>

                    @if($item->tanggal_mulai)

                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}

                    @else

                        -

                    @endif

                </td>

                <td>

                    @if($item->estimasi_selesai)

                        {{ \Carbon\Carbon::parse($item->estimasi_selesai)->format('d M Y') }}

                    @else

                        -

                    @endif

                </td>

                <td>

                    <div class="action-buttons">

                        <a href="{{ route('tracking-pesanan.edit',$item->id_tracking) }}"
                           class="btn-edit">

                            Edit

                        </a>

                        <form action="{{ route('tracking-pesanan.destroy',$item->id_tracking) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn-delete"
                                    onclick="return confirm('Hapus tracking?')">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7">

                    Data tracking kosong

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection