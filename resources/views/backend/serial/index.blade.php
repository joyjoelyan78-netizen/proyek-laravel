@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/serial-produk.css') }}">

<div class="page-header">

    <h1>Serial Produk</h1>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>Kode Serial</th>
                <th>Invoice</th>
                <th>Produk</th>
                <th>Customer</th>
                <th>Status Garansi</th>
                <th>Masa Berlaku</th>
                <th width="160">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($serial as $item)

            <tr>

                <td>

                    <strong>

                        {{ $item->kode_unik }}

                    </strong>

                </td>

                <td>

                    @if($item->pesanan)

                        {{ $item->pesanan->nomor_invoice }}

                    @else

                        -

                    @endif

                </td>

                <td>

                    @if($item->produk)

                        {{ $item->produk->nama_produk }}

                    @else

                        <span class="text-danger">

                            Produk tidak ditemukan

                        </span>

                    @endif

                </td>

                <td>

                    @if($item->customer)

                        {{ $item->customer->nama_customer }}

                    @else

                        <span class="text-secondary">

                            Belum ada customer

                        </span>

                    @endif

                </td>

                <td>

                    @if($item->status_garansi == 'aktif')

                        <span class="badge-active">

                            Aktif

                        </span>

                    @elseif($item->status_garansi == 'pending')

                        <span class="badge-role">

                            Pending

                        </span>

                    @elseif($item->status_garansi == 'claimed')

                        <span class="badge-role">

                            Sudah Diklaim

                        </span>

                    @elseif($item->status_garansi == 'expired')

                        <span class="badge-nonactive">

                            Expired

                        </span>

                    @else

                        <span class="badge-nonactive">

                            Void

                        </span>

                    @endif

                </td>

                <td>

                    {{ $item->masa_berlaku_sampai ?? '-' }}

                </td>

                <td>

                    <div class="action-buttons">

                        <a href="{{ route('serial-produk.show', $item->id_serial) }}"
                           class="btn-edit">

                            Detail

                        </a>

                        <form action="{{ route('serial-produk.destroy', $item->id_serial) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn-delete"
                                    onclick="return confirm('Hapus serial produk?')">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7"
                    style="text-align:center;">

                    Data serial produk kosong

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection