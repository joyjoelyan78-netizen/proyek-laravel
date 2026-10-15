@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/kategori-produk.css') }}">

<div class="page-header">

    <h1>Kategori Produk</h1>

    <a href="/admin/kategori-produk/create"
       class="btn-primary">

       + Tambah Kategori

    </a>

</div>

<div class="card-table">

    <table>

        <thead>
            <tr>
                <th width="80">No</th>
                <th>Nama Kategori</th>
                <th width="190">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @foreach($kategori as $k)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>

                <strong>{{ $k->nama_kategori }}</strong>

            </td>

            <td>

                <div class="action-buttons">

                    <a href="/admin/kategori-produk/{{ $k->id_kategori }}/edit"
                       class="btn-edit">

                       Edit

                    </a>

                    <form action="/admin/kategori-produk/{{ $k->id_kategori }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button class="btn-delete"
                                onclick="return confirm('Hapus kategori?')">

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