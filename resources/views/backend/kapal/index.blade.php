@extends('layouts.backend')

@section('content')

<div class="page-header">

    <h1>Data Kapal</h1>

    <a href="{{ route('kapal.create') }}"
       class="btn-primary">

        + Tambah Kapal

    </a>

</div>

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Nama Kapal</th>
                <th>Jenis Kapal</th>
                <th>Dibuat</th>
                <th width="180">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($kapal as $item)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>

                    <strong>
                        {{ $item->nama_kapal }}
                    </strong>

                </td>

                <td>

                    <span class="badge-role">

                        {{ $item->jenis_kapal }}

                    </span>

                </td>

                <td>

                    @if($item->created_at)

                        {{ $item->created_at->format('d M Y') }}

                    @else

                        -

                    @endif

                </td>

                <td>

                    <div class="action-buttons">

                        <a href="{{ route('kapal.edit', $item->id_kapal) }}"
                           class="btn-edit">

                            Edit

                        </a>

                        <form action="{{ route('kapal.destroy', $item->id_kapal) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn-delete"
                                    onclick="return confirm('Hapus kapal?')">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5"
                    style="text-align:center;">

                    Data kapal kosong

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection