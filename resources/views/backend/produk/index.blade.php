@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/admin_produk.css') }}">

<div class="page-header">

    <h1>Data Produk</h1>

    <a href="/admin/produk/create" class="btn-primary">
        + Tambah Produk
    </a>

</div>

<div class="card-table">

    <table>

        <thead>
            <tr>
                <th>Foto</th>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Berat</th>
                <th>Garansi</th>
                <th>Status</th>
                <th width="190">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @foreach($produk as $p)

        <tr>

            <td width="90">

                @if($p->gambar_produk)

                    <img src="{{ asset('storage/'.$p->gambar_produk) }}"
                         class="product-image">

                @else

                    -

                @endif

            </td>

            <td>
                <strong>{{ $p->kode_produk }}</strong>
            </td>

            <td>
                <strong>{{ $p->nama_produk }}</strong>
                <br>

                <small class="text-secondary">
                    {{ $p->seri_produk }}
                </small>
            </td>

            <td>

                <span class="badge-role">
                    {{ $p->kategori->nama_kategori }}
                </span>

            </td>

            <td>{{ $p->berat }} Kg</td>

            <td>{{ $p->masa_garansi_bulan }} Bulan</td>

            <td>

                @if($p->status_produk == 'aktif')

                    <span class="badge-active">
                        Aktif
                    </span>

                @else

                    <span class="badge-nonactive">
                        Nonaktif
                    </span>

                @endif

            </td>

            <td>

                <div class="action-buttons">

                    <a href="/admin/produk/{{ $p->id_produk }}/edit"
                       class="btn-edit">

                        Edit

                    </a>

                    <form action="/admin/produk/{{ $p->id_produk }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button class="btn-delete"
                                onclick="return confirm('Hapus produk?')">

                            Hapus

                        </button>

                    </form>

                </div>

            </td>

        </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection