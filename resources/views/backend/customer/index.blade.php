@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/customer.css') }}">

<div class="page-header">

    <h1>Data Customer</h1>

    <a href="{{ route('customer.create') }}"
       class="btn-primary">

        + Tambah Customer

    </a>

</div>

<div class="card-table">

    <table>

        <thead>
            <tr>
                <th width="70">No</th>
                <th>Nama Customer</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Alamat</th>
                <th>Dibuat</th>
                <th width="190">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($customer as $item)

        <tr>

            <td>
                <strong>{{ $loop->iteration }}</strong>
            </td>

            <td>

                <strong>
                    {{ $item->nama_customer }}
                </strong>

            </td>

            <td>

                @if($item->email)

                    {{ $item->email }}

                @else

                    <span class="text-secondary">
                        Tidak ada email
                    </span>

                @endif

            </td>

            <td>

                @if($item->nomor_telepon)

                    {{ $item->nomor_telepon }}

                @else

                    <span class="text-secondary">
                        Tidak ada nomor
                    </span>

                @endif

            </td>

            <td>

                @if($item->alamat)

                    {{ $item->alamat }}

                @else

                    <span class="text-secondary">
                        Tidak ada alamat
                    </span>

                @endif

            </td>

            <td>

                @if($item->created_at)

                    {{ date('d M Y', strtotime($item->created_at)) }}   

                @else

                    -

                @endif

            </td>

            <td>

                <div class="action-buttons">

                    <a href="{{ route('customer.edit', $item->id_customer) }}"
                       class="btn-edit">

                        Edit

                    </a>

                    <form action="{{ route('customer.destroy', $item->id_customer) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn-delete"
                                onclick="return confirm('Hapus customer ini?')">

                            Hapus

                        </button>

                    </form>

                </div>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="7"
                style="text-align:center; padding:30px;">

                <span class="text-secondary">
                    Data customer kosong
                </span>

            </td>

        </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection