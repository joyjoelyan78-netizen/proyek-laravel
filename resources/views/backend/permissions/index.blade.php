@extends('layouts.backend')

@section('content')

<div class="page-header">
    <h1>Permission Management</h1>
</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>Role</th>

                @foreach($permissions as $permission)

                    <th>
                        {{ $permission->nama_permission }}
                    </th>

                @endforeach

            </tr>

        </thead>

        <tbody>

            @foreach($roles as $role)

            <tr>

                <td>
                    <strong>
                        {{ $role->nama_role }}
                    </strong>
                </td>

                @foreach($permissions as $permission)

                <td>

                    <label class="switch">

                        <input
                            type="checkbox"

                            class="toggle-permission"

                            data-role="{{ $role->id_role }}"
                            data-permission="{{ $permission->id_permission }}"

                            {{ $role->permissions->contains('id_permission', $permission->id_permission) ? 'checked' : '' }}
                        >

                        <span class="slider"></span>

                    </label>

                </td>

                @endforeach

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection