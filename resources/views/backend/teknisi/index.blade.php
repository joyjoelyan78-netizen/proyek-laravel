@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/teknisi.css') }}">

<div class="page-header">

    <div>
        <h1>Data Teknisi</h1>
    </div>

    <a href="{{ route('teknisi.create') }}"
       class="btn-primary">

        + Tambah Teknisi

    </a>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Nama Teknisi</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Status</th>
                <th width="170">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($teknisi as $item)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>

                    <strong>
                        {{ $item->nama_teknisi }}
                    </strong>

                </td>

                <td>

                    {{ $item->email ?? '-' }}

                </td>

                <td>

                    {{ $item->nomor_telepon ?? '-' }}

                </td>

                <td>

                    @if($item->status_teknisi == 'aktif')

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

                        <a href="{{ route('teknisi.edit', $item->id_teknisi) }}"
                           class="btn-edit">

                            Edit

                        </a>

                        <form action="{{ route('teknisi.destroy', $item->id_teknisi) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn-delete"
                                    onclick="return confirm('Hapus teknisi ini?')">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6"
                    class="text-secondary">

                    Data teknisi kosong

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection