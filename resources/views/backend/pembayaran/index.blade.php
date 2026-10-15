@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/pembayaran.css') }}">

<div class="page-header">

    <h1>Data Pembayaran</h1>

    <a href="{{ route('pembayaran.create') }}"
       class="btn-primary">

        + Tambah Pembayaran

    </a>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>Invoice</th>
                <th>Customer</th>
                <th>Nominal</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Input Oleh</th>
                <th width="180">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($pembayaran as $item)

            <tr>

                <td>
                    <strong>
                        {{ $item->pesanan->nomor_invoice }}
                    </strong>
                </td>

                <td>
                    {{ $item->pesanan->customer->nama_customer }}
                </td>

                <td>

                    Rp
                    {{ number_format($item->nominal,0,',','.') }}

                </td>

                <td>

                    {{ $item->metode_pembayaran ?? '-' }}

                </td>

                <td>

                    @if($item->status_pembayaran == 'lunas')

                        <span class="badge-active">
                            Lunas
                        </span>

                    @elseif($item->status_pembayaran == 'dp')

                        <span class="badge-role">
                            DP
                        </span>

                    @else

                        <span class="badge-nonactive">
                            Belum Bayar
                        </span>

                    @endif

                </td>

                <td>

                    {{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d M Y') }}

                </td>

                <td>

                    {{ $item->user->nama }}

                </td>

                <td>

                    <div class="action-buttons">

                        <a href="{{ route('pembayaran.edit',$item->id_pembayaran) }}"
                           class="btn-edit">

                            Edit

                        </a>

                        <form action="{{ route('pembayaran.destroy',$item->id_pembayaran) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn-delete"
                                    onclick="return confirm('Hapus pembayaran?')">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8">

                    Tidak ada data pembayaran

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection