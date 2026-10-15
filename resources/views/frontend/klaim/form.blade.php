<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Form Klaim Garansi</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/form_klaim.css') }}"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

</head>
<body>

<div class="claim-wrapper">

    <!-- STEP -->
    <div class="step-wrapper">

        <div class="step done">
            <div class="circle">1</div>
            <span>Kode Unik</span>
        </div>

        <div class="line active"></div>

        <div class="step done">
            <div class="circle">2</div>
            <span>Detail Produk</span>
        </div>

        <div class="line active"></div>

        <div class="step active">
            <div class="circle">3</div>
            <span>Klaim</span>
        </div>

        <div class="line"></div>

        <div class="step">
            <div class="circle">4</div>
            <span>Tiket</span>
        </div>

        <div class="line"></div>

        <div class="step">
            <div class="circle">5</div>
            <span>Hasil</span>
        </div>

    </div>

    <!-- CARD -->
    <div class="claim-card">

        <h1>
            Klaim Garansi
        </h1>

        <p class="subtitle">

            Masukkan data sesuai invoice pembelian

        </p>

        {{-- ERROR --}}
        @if(session('error'))

            <div class="error-alert">

                <i class="fas fa-exclamation-circle"></i>

                {{ session('error') }}

            </div>

        @endif

        {{-- VALIDATION --}}
        @if ($errors->any())

            <div class="error-alert">

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('klaim.garansi.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <!-- ID SERIAL -->
            <input
                type="hidden"
                name="id_serial"
                value="{{ $serial->id_serial }}"
            >

            <!-- KODE -->
            <div class="form-group">

                <label>
                    Kode unik produk
                </label>

                <input
                    type="text"
                    name="kode_unik"
                    value="{{ $serial->kode_unik }}"
                    readonly
                >

                <small>

                    Kode serial produk terverifikasi

                </small>

            </div>

            <!-- NAMA -->
            <div class="form-group">

                <label>
                    Nama pembeli
                </label>

                <input
                    type="text"
                    name="nama_pembeli"
                    placeholder="Nama sesuai invoice"
                    required
                >

            </div>

            <!-- EMAIL -->
            <div class="form-group">

                <label>
                    Alamat email
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="email@gmail.com"
                    required
                >

                <small>

                    Hasil klaim dikirim ke email ini

                </small>

            </div>

            <!-- TELEPON -->
            <div class="form-group">

                <label>
                    Nomor telepon
                </label>

                <input
                    type="text"
                    name="nomor_telepon"
                    placeholder="+62 812 xxxx xxxx"
                    required
                >

            </div>

            <!-- FOTO -->
            <div class="form-group">

                <label>
                    Upload foto bukti pemasangan
                </label>

                <label class="upload-box">

                    <input
                        type="file"
                        name="foto_bukti"
                        id="fotoInput"
                        hidden
                        required
                    >

                    <i class="fas fa-camera"></i>

                    <h4>
                        Klik untuk upload foto
                    </h4>

                    <p>
                        JPG, PNG — Maksimal 5MB
                    </p>

                </label>

            </div>

            <!-- SUCCESS FILE -->
            <div
                class="upload-success"
                id="uploadSuccess"
            >

                Foto berhasil dipilih

            </div>

            <!-- INFO -->
            <div class="info-box">

                <span>!</span>

                <p>

                    Nama pembeli wajib sesuai
                    dengan invoice pembelian produk.

                </p>

            </div>

            <!-- BUTTON -->
            <div class="button-wrapper">

                <a
                    href="{{ route('klaim.garansi') }}"
                    class="btn-back"
                >

                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn-next"
                >

                    Ajukan Klaim

                </button>

            </div>

        </form>

    </div>

</div>

<script>

const fotoInput = document.getElementById('fotoInput');
const uploadSuccess = document.getElementById('uploadSuccess');

fotoInput.addEventListener('change', function(){

    if(this.files.length > 0){

        uploadSuccess.style.display = 'flex';

        uploadSuccess.innerHTML = `
            ✓ Foto berhasil dipilih:
            <b>${this.files[0].name}</b>
        `;
    }

});

</script>

</body>
</html>