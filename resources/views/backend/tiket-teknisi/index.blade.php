@extends('layouts.backend')

@section('content')

<div class="page-header">

    <h1>Tiket Teknisi</h1>

    <a href="{{ route('tiket-teknisi.create') }}"
       class="btn-primary">

        + Tambah Tiket

    </a>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>No Tiket</th>
                <th>Customer</th>
                <th>Produk</th>
                <th>Teknisi</th>
                <th>Status</th>
                <th>Estimasi</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($tiket as $item)

                <tr>

                    <td>
                        {{ $item->nomor_tiket }}
                    </td>

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
                        {{ $item->status_tiket }}
                    </td>

                    <td>

                        @if($item->estimasi_kunjungan)

                            {{ \Carbon\Carbon::parse($item->estimasi_kunjungan)->format('d M Y H:i') }}

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        <div class="action-buttons">

                            <a href="{{ route('tiket-teknisi.edit', $item->id_tiket) }}"
                               class="btn-edit">

                                Edit

                            </a>

                            <form action="{{ route('tiket-teknisi.destroy', $item->id_tiket) }}"
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

                        Data tiket kosong

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection