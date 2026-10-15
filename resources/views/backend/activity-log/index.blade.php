@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
      href="{{ asset('css/activity-log.css') }}">

<div class="page-header">

    <h1>Activity Log</h1>

</div>

@if(session('success'))

    <div class="alert-success-custom">

        {{ session('success') }}

    </div>

@endif

<div class="card-table">

    <table>

        <thead>

            <tr>

                <th>User</th>
                <th>Aktivitas</th>
                <th>Tabel</th>
                <th>ID Data</th>
                <th>IP Address</th>
                <th>Tanggal</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($logs as $item)

                <tr>

                    <td>

                        {{ $item->user->nama ?? '-' }}

                    </td>

                    <td>

                        {{ $item->aktivitas }}

                    </td>

                    <td>

                        {{ $item->tabel_terkait }}

                    </td>

                    <td>

                        {{ $item->id_data ?? '-' }}

                    </td>

                    <td>

                        {{ $item->ip_address ?? '-' }}

                    </td>

                    <td>

                        @if($item->created_at)

                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}

                        @else

                            -

                        @endif

                    </td>

                    <td>

                        <div class="action-buttons">

                            <a href="{{ route('activity-log.show', $item->id_log) }}"
                               class="btn-edit">

                                Detail

                            </a>

                            <form action="{{ route('activity-log.destroy', $item->id_log) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus log ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn-delete">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7"
                        style="text-align:center;">

                        Tidak ada activity log

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection