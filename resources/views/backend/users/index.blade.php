@extends('layouts.backend')

@section('content')

<link rel="stylesheet" href="/css/user-admin.css">

<div class="page-header">
    <h1>Akun Admin</h1>
    <a href="{{ route('admin.users.create') }}" class="btn-primary">+ Tambah Akun</a>
</div>

@if (session('success'))
    <div style="background:#d4edda;color:#155724;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div style="background:#f8d7da;color:#721c24;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;">{{ session('error') }}</div>
@endif

<div class="card-table">

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Peran</th>
                <th width="220">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($users as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td><strong>{{ $item->nama }}</strong></td>

                    <td>{{ $item->email }}</td>

                    <td>
                        @if ($item->hasRole('Super Admin'))
                            <span class="badge-superadmin">Super Admin</span>
                        @else
                            <span class="badge-role">Staf Admin</span>
                        @endif
                    </td>

                    <td>

                        @if ($item->hasRole('Super Admin'))

                            <span class="badge-superadmin">Protected</span>

                        @else

                            <div class="action-buttons">

                                <a href="{{ route('admin.users.edit', $item->id_user) }}" class="btn-edit">Edit</a>

                                <form action="{{ route('admin.users.destroy', $item->id_user) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus akun ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
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
