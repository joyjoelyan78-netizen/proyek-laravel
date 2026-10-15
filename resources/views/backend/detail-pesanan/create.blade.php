@extends('layouts.backend')

@section('content')

<link rel="stylesheet"
href="{{ asset('css/detail-pesanan.css') }}">

<div class="page-header">

    <h1>Tambah Detail Pesanan</h1>

</div>

<form action="{{ route('detail-pesanan.store') }}"
      method="POST">

    @csrf

    <div class="card-form">

        <h3>Informasi Detail Pesanan</h3>

        <div class="form-group">

            <label>Invoice</label>

            <select name="id_pesanan" required>

                @foreach($pesanan as $item)

                <option value="{{ $item->id_pesanan }}">
                    {{ $item->nomor_invoice }}
                </option>

                @endforeach

            </select>

        </div>

    </div>

    <div id="produk-wrapper">

        <div class="card-form produk-item">

            <h3>Produk Pesanan</h3>

            <div class="form-group">

                <label>Produk</label>

                <select name="id_produk[]" required>

                    @foreach($produk as $item)

                    <option value="{{ $item->id_produk }}">
                        {{ $item->nama_produk }}
                    </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>Qty</label>

                <input type="number"
                       name="qty[]"
                       min="1"
                       required>

            </div>

            <div class="form-group">

                <label>Harga</label>

                <input type="number"
                       name="harga[]"
                       required>

            </div>

            <div class="form-group">

                <label>Berat per Unit (Kg)</label>

                <input type="number"
                       step="0.01"
                       name="berat_per_unit[]">

            </div>

        </div>

    </div>

    <div style="margin-bottom:20px;">

        <button type="button"
                id="tambahProduk"
                class="btn-secondary">

            + Tambah Produk

        </button>

    </div>

    <div class="form-footer">

        <a href="{{ route('detail-pesanan.index') }}"
           class="btn-back">

            Kembali

        </a>

        <button type="submit"
                class="btn-primary">

            Simpan Detail Pesanan

        </button>

    </div>

</form>

<script>

document.getElementById('tambahProduk')
.addEventListener('click', function(){

    let wrapper =
        document.getElementById('produk-wrapper');

    let item =
        document.querySelector('.produk-item');

    let clone =
        item.cloneNode(true);

    clone.querySelectorAll('input')
        .forEach(input => input.value = '');

    wrapper.appendChild(clone);

});

</script>

@endsection