@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/role-user.css') }}">

<div class="page-header">

    <h1>Data Role</h1>

    <a href="/admin/roles/create" class="btn-primary">
        + Tambah Role
    </a>

</div>

<div class="card-table">

    <table>

        <thead>
            <tr>
                <th width="80">No</th>
                <th>Nama Role</th>
                <th>Deskripsi</th>
                <th width="220">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @foreach($roles as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>
                    <strong>{{ $item->nama_role }}</strong>
                </td>

                <td>

                    @if($item->deskripsi)
                        {{ $item->deskripsi }}
                    @else
                        <span style="color:#94a3b8;">
                            Tidak ada deskripsi
                        </span>
                    @endif

                </td>

                <td>

                    <div class="action-buttons">

                        <a href="/admin/roles/{{ $item->id_role }}/edit"
                           class="btn-edit">

                            Edit

                        </a>

                        <form action="/admin/roles/{{ $item->id_role }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn-delete"
                                    onclick="return confirm('Hapus role ini?')">

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