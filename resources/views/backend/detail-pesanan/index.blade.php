@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/detail-pesanan.css') }}">

<div class="page-header">

    <h1>Detail Pesanan</h1>

    <a href="{{ route('detail-pesanan.create') }}"
       class="btn-primary">

        + Tambah Detail

    </a>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>Invoice</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($detail as $item)

            <tr>

                <td>
                    {{ $item->pesanan->nomor_invoice }}
                </td>

                <td>
                    {{ $item->produk->nama_produk }}
                </td>

                <td>
                    {{ $item->qty }}
                </td>

                <td>
                    Rp {{ number_format($item->harga) }}
                </td>

                <td>
                    Rp {{ number_format($item->subtotal) }}
                </td>

                <td>

                    <div class="action-buttons">

                        <a href="{{ route('detail-pesanan.edit', $item->id_detail) }}"
                           class="btn-edit">

                            Edit

                        </a>

                        <form action="{{ route('detail-pesanan.destroy', $item->id_detail) }}"
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

                <td colspan="6"
                    style="text-align:center;">

                    Tidak ada detail pesanan

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection