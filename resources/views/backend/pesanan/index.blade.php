@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/pesanan.css') }}">

<div class="page-header">

    <div>

        <h1>Data Pesanan</h1>

    </div>

    <a href="{{ route('pesanan.create') }}"
       class="btn-primary">

        + Tambah Pesanan

    </a>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>No Invoice</th>
                <th>Customer</th>
                <th>Tanggal Order</th>
                <th>Estimasi</th>
                <th>Progress</th>
                <th>Status</th>
                <th width="200">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($pesanan as $item)

            <tr>

                <td>

                    <strong>
                        {{ $item->nomor_invoice }}
                    </strong>

                </td>

                <td>

                    {{ $item->customer->nama_customer }}

                </td>

                <td>

                    {{ \Carbon\Carbon::parse($item->tanggal_order)->format('d M Y') }}

                </td>

                <td>

                    {{ $item->estimasi_selesai
                        ? \Carbon\Carbon::parse($item->estimasi_selesai)->format('d M Y')
                        : '-'
                    }}

                </td>

                <td>

                    {{ $item->progres_persen }}%

                </td>

                <td>

                    @if($item->status_pesanan == 'diproses')

                        <span class="badge-role">
                            Diproses
                        </span>

                    @elseif($item->status_pesanan == 'selesai')

                        <span class="badge-active">
                            Selesai
                        </span>

                    @elseif($item->status_pesanan == 'dikirim')

                        <span class="badge-superadmin">
                            Dikirim
                        </span>

                    @else

                        <span class="badge-nonactive">
                            Diterima
                        </span>

                    @endif

                </td>

                <td>

                    <div class="action-buttons">

                        <a href="{{ route('pesanan.show', $item->id_pesanan) }}"
                           class="btn-primary">

                            Detail

                        </a>

                        <a href="{{ route('pesanan.edit', $item->id_pesanan) }}"
                           class="btn-edit">

                            Edit

                        </a>

                        <form action="{{ route('pesanan.destroy', $item->id_pesanan) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn-delete"
                                    onclick="return confirm('Hapus pesanan?')">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7">

                    Data pesanan kosong

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection