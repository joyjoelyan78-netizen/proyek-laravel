@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/user-admin.css') }}">

<div class="page-header">

    <h1>User Admin</h1>

    <a href="/admin/users/create" class="btn-primary">
        + Tambah User
    </a>

</div>

<div class="card-table">

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th width="220">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @foreach($users as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>
                    <strong>{{ $item->nama }}</strong>
                </td>

                <td>{{ $item->email }}</td>

                <td>

                    @foreach($item->roles as $role)

                        <span class="badge-role">
                            {{ $role->nama_role }}
                        </span>

                    @endforeach

                </td>

                <td>

                    @if($item->status_user == 'aktif')

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

                    @if($item->hasRole('Super Admin'))

                        <span class="badge-superadmin">
                            Protected
                        </span>

                    @else

                        <div class="action-buttons">

                            <a href="/admin/users/{{ $item->id_user }}/edit"
                               class="btn-edit">

                                Edit

                            </a>

                            <form action="/admin/users/{{ $item->id_user }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="btn-delete"
                                        onclick="return confirm('Hapus user?')">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection