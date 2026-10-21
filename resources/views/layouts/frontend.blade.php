    <!DOCTYPE html>
    <html lang="id">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>VESCA - PT Vescarindo Utama</title>

        <meta name="description"
            content="PT Vescarindo Utama memproduksi Aluminium Anode dan Zinc Anode berkualitas tinggi untuk perlindungan korosi industri.">

            <link rel="stylesheet" href="/css/frontend.css">

            <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
            <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>

            <link rel="preload" href="https://unpkg.com/aos@next/dist/aos.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
            <noscript><link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"></noscript>

        <link 
        rel="preload"
        as="image"
        href="/image/background.webp">

    @stack('styles')
    @stack('scripts')
    </head>
    <body>

    <!-- NAVBAR -->
    <nav class="navbar">

        <div class="nav-container">

            <!-- LOGO -->
            <div class="logo" data-aos="fade-down" data-aos-duration="800">
                <img
                    src="/image/Vesca New logo.webp"
                    alt="Logo VESCA"
                    width="220"
                    height="70">
            </div>


            <!-- HAMBURGER MOBILE -->
            <button
                class="hamburger"
                id="hamburger"
                type="button"
                aria-label="Buka menu">

                <span></span>
                <span></span>
                <span></span>

            </button>


            <!-- MENU -->
            <ul class="menu" id="main-menu">

                <li data-aos="fade-down" data-aos-delay="200">
                    <a href="/">Beranda</a>
                </li>

                <li data-aos="fade-down" data-aos-delay="300">
                    <a href="{{ route('produk') }}">
                        Produk
                    </a>
                </li>

                <li
                    class="dropdown"
                    id="layanan-menu"
                    data-aos="fade-down"
                    data-aos-delay="400">

                    <a
                        href="#"
                        id="layanan-toggle">

                        Layanan
                        <i class="fas fa-chevron-down mobile-chevron"></i>

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a href="{{ route('penawaran.index') }}">
                                Minta Penawaran Resmi
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('konsultasi.index') }}">
                                Konsultasi &amp; Spesifikasi Teknis
                            </a>
                        </li>

                    </ul>

                </li>


                <li data-aos="fade-down" data-aos-delay="500">
                    <a href="{{ url('/tentang-kami') }}">
                        Tentang Kami
                    </a>
                </li>

                <li data-aos="fade-down" data-aos-delay="550">
                    <a href="{{ route('galeri') }}">
                        Galeri
                    </a>
                </li>


                <li data-aos="fade-down" data-aos-delay="600">
                    <a href="{{ route('hubungi') }}">
                        Hubungi Kami
                    </a>
                </li>

            </ul>


            <!-- SEARCH -->
            <div class="box" data-aos="fade-down" data-aos-delay="800">

                <form
                    action="{{ route('produk') }}"
                    method="GET">

                    <input
                        type="text"
                        name="search"
                        id="search-input"
                        placeholder="Search..."
                        autocomplete="off">

                    <button
                        type="button"
                        aria-label="Cari Produk">

                        <i class="fas fa-search"></i>

                    </button>

                </form>

                <!-- SEARCH RESULT -->
                <div
                    class="search-result"
                    id="search-result">
                </div>

            </div>

        </div>

    </nav>

    <!-- CONTENT -->
    <main>

        {{-- TOMBOL KEMBALI: otomatis muncul di semua halaman kecuali beranda.
             Halaman bisa mengatur tujuan cadangan dengan
             @section('kembali_ke', '/produk') --}}
        @unless (request()->is('/'))
            <div class="back-bar">
                <a href="@yield('kembali_ke', '/')" class="btn-kembali" aria-label="Kembali ke halaman sebelumnya">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        @endunless

        @yield('content')

    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-container">

            <!-- KIRI -->
            <div class="footer-left" data-aos="fade-down" data-aos-duration="2000">
                <img
                    src="/image/vesca new logo white.png"
                    class="footer-logo"
                    alt="Logo PT Vescarindo Utama"
                    width="220"
                    height="70">

                <p>
                    PT. Vescarindo Utama adalah salah satu perusahaan yang khusus <br> bergerak
                    dalam bidang korosi dengan memproduksi Aluminium <br> dan Zinc anode dengan
                    merk dagang “VESCA” dan berdiri sejak <br> tahun 1997.
                </p>
            </div>

            <!-- TENGAH -->
            <div class="footer-middle" data-aos="fade-down" data-aos-duration="2000">
                <h3>Navigasi</h3>
                <ul>
                <li><a href="/">Beranda</a></li>
                <li><a href="{{ url('/tentang-kami') }}">Perusahaan</a></li>
                <li><a href="{{ route('produk') }}">Produk</a></li>
                <li><a href="{{ route('galeri') }}">Galeri</a></li>
                <li><a href="{{ route('hubungi') }}">Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- KANAN -->
            <div class="footer-right" data-aos="fade-down" data-aos-duration="2000">
                <h3>Vescarindo Utama</h3>

                <p><i class="fas fa-location-dot"></i> {{ config('vesca.alamat_footer') }}</p>
                @foreach (config('vesca.kontak_wa') as $kontak)
                    <p>
                        <i class="fab fa-whatsapp"></i>
                        <a class="footer-link"
                           href="https://wa.me/{{ $kontak['nomor'] }}?text={{ rawurlencode('Halo PT Vescarindo Utama, saya ingin bertanya mengenai produk Vesca.') }}"
                           target="_blank" rel="noopener"
                           title="Chat via WhatsApp">{{ $kontak['label'] }}</a>
                    </p>
                @endforeach

                <p>
                    <i class="fas fa-envelope"></i>
                    <a class="footer-link"
                       href="mailto:{{ config('vesca.email') }}?subject={{ rawurlencode('Pertanyaan produk Vesca') }}"
                       title="Kirim email">{{ config('vesca.email') }}</a>
                </p>
            </div>

        </div>

        <div class="footer-bottom">
            Copyright © ptvescarindoutama | Powered by NIC
        </div>
    </footer>

    <!-- SCRIPT -->

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 600,
            disable: window.innerWidth < 768
        });
    </script>

    <script>

    /* =====================================================
    MOBILE HAMBURGER MENU
    ===================================================== */

    const hamburger =
        document.getElementById('hamburger');

    const mainMenu =
        document.getElementById('main-menu');

    const layananMenu =
        document.getElementById('layanan-menu');

    const layananToggle =
        document.getElementById('layanan-toggle');


    /* BUKA / TUTUP MENU */

    hamburger.addEventListener('click', function(e) {

        e.stopPropagation();

        hamburger.classList.toggle('active');

        mainMenu.classList.toggle('active');

    });


    /* DROPDOWN LAYANAN DI MOBILE */

    layananToggle.addEventListener('click', function(e) {

        /*
        * Di desktop tetap menggunakan hover.
        * Di mobile kita menggunakan klik.
        */

        if (window.innerWidth <= 1024) {

            e.preventDefault();

            layananMenu.classList.toggle('mobile-open');

        }

    });


    /* KLIK DI LUAR MENU */

    document.addEventListener('click', function(e) {

        if (
            window.innerWidth <= 1024 &&
            !mainMenu.contains(e.target) &&
            !hamburger.contains(e.target)
        ) {

            mainMenu.classList.remove('active');

            hamburger.classList.remove('active');

            layananMenu.classList.remove('mobile-open');

        }

    });


    /* KALAU BALIK KE DESKTOP */

    window.addEventListener('resize', function() {

        if (window.innerWidth > 1024) {

            mainMenu.classList.remove('active');

            hamburger.classList.remove('active');

            layananMenu.classList.remove('mobile-open');

        }

    });

    </script>

    <script>

    const searchInput = document.getElementById('search-input');
    const searchResult = document.getElementById('search-result');

    let timerCari = null;

    function amankan(teks){
        return String(teks)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    searchInput.addEventListener('input', function(){

        const search = this.value.trim();

        clearTimeout(timerCari);

        if(search.length < 1){

            searchResult.style.display = 'none';
            return;
        }

        timerCari = setTimeout(function(){

            fetch('/search-produk?search=' + encodeURIComponent(search))

            .then(response => response.json())

            .then(data => {

                let html = '';

                if(data.length > 0){

                    data.forEach(item => {

                        html += '<a class="search-item" href="' + amankan(item.url) + '">'
                              + amankan(item.label) + '</a>';
                    });

                } else {

                    html = '<div class="search-item">Produk tidak ditemukan</div>';
                }

                searchResult.innerHTML = html;
                searchResult.style.display = 'block';

            });

        }, 180);

    });

    /* HIDE */
    document.addEventListener('click', function(e){

        if(!document.querySelector('.box').contains(e.target)){

            searchResult.style.display = 'none';
        }

    });

    </script>

    <!-- CHATBOT BUTTON -->
    <button
        id="chatbot-toggle"
        aria-label="Buka Chatbot">

        <i class="fas fa-robot"></i>

    </button>
    <!-- CHATBOT BOX -->
    <div id="chatbot-box">

        <div class="chat-header">

            <div class="chat-title">
                <i class="fas fa-robot"></i>
                Vesca AI Assistant
            </div>

            <span id="close-chat">
                <i class="fas fa-times"></i>
            </span>

        </div>

        <div id="chat-messages">

            <div class="bot-message">
                Halo 👋 Ada yang bisa saya bantu mengenai produk atau layanan Vesca?
            </div>

        </div>

        <div class="chat-input">

            <input
                type="text"
                id="userMessage"
                placeholder="Tulis pertanyaan..."
            >

            <button onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>

        </div>

    </div>

    <script>

    const toggle =
    document.getElementById('chatbot-toggle');

    const box =
    document.getElementById('chatbot-box');

    const closeChat =
    document.getElementById('close-chat');

    toggle.onclick = () => {

    box.classList.add('show');

    };

    closeChat.onclick = () => {

    box.classList.remove('show');

    };

    async function sendMessage()
    {
        let input =
        document.getElementById('userMessage');

        let message =
        input.value.trim();

        if(!message) return;

        let chat =
        document.getElementById('chat-messages');

        chat.innerHTML +=
        `<div class="user-message">${message}</div>`;

        input.value='';

        chat.innerHTML += `
        <div class="typing" id="typing">
            <span></span>
            <span></span>
            <span></span>
        </div>
        `;

        chat.scrollTop =
        chat.scrollHeight;

        let response =
        await fetch('/chatbot',{

            method:'POST',

            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':
                '{{ csrf_token() }}'
            },

            body:JSON.stringify({
                message:message
            })

        });

        let data =
        await response.json();

        document
        .getElementById('typing')
        ?.remove();

        chat.innerHTML +=
        `<div class="bot-message">${data.reply}</div>`;

        chat.scrollTop =
        chat.scrollHeight;
    }

    document.addEventListener('click', function(e){

    const klikDiChatbot =
        box.contains(e.target);

    const klikTombolRobot =
        toggle.contains(e.target);

    if(
        !klikDiChatbot &&
        !klikTombolRobot
    ){
        box.classList.remove('show');
    }

    });

    toggle.onclick = (e) => {

    e.stopPropagation();

    box.classList.toggle('show');

    };

    </script>

        <script>

    /* TOMBOL KEMBALI: kalau pengunjung datang dari halaman lain di website ini,
       kembali ke halaman itu; kalau tidak (misal buka lewat link langsung),
       pakai alamat cadangan di tombolnya. */

    document.querySelectorAll('.btn-kembali').forEach(function (tombol) {

        tombol.addEventListener('click', function (e) {

            try {

                if (
                    document.referrer &&
                    new URL(document.referrer).origin === window.location.origin &&
                    window.history.length > 1
                ) {

                    e.preventDefault();
                    window.history.back();
                }

            } catch (err) { /* abaikan, ikuti alamat cadangan */ }

        });

    });

    </script>

    <!-- RESPONSIVE (dimuat terakhir supaya menimpa CSS tiap halaman) -->
    <link rel="stylesheet" href="/css/responsive.css">

    </body>
    </html>