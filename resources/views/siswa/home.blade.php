<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hai {{ $user->name }}</title>
        <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('css/siswa-home.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card-name.css') }}">
        <link rel="stylesheet" href="{{ asset('css/notifikasi.css') }}">
        <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- <script rel="stylesheet" href="{{ asset('js/notifications.js') }}"></script> -->
    </head>
    <div>
        <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
        <header>
            <h2 class="logo">Selamat datang</h2>
            <nav class="navigation">
                <a href="#home" class="active">Home</a>
                <a href="#karir" >Karir</a>
                <a href="{{ route('siswa.event', [$user->slug]) }}" >Service</a>
                <br>
                @auth
                    <span class="username"><a href="{{ route('siswa.edit-profile', [$user->slug]) }}">{{ Auth::user()->name }}</a></span>
                    <div class="notifikasi">
                        <i class="fa-regular fa-envelope" id="notificationIcon"></i>
                        <span class="dot" data-count="0"></span>
                        <div class="pesan-dropdown" id="notificationDropdown">
                            <ul id="notificationList"></ul>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}">Logout</a>
                    <div id="toast-container"></div>
                @endauth
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endguest
                <div class="menu-icon" id="menu"><i class="fa-solid fa-burger"></i></div>

                <div class="nav-dropdown" id="dropdown" style="display: none;">
                    <a href="#home" >Home</a>
                    <a href="#about" >About</a>
                    @auth
                        <a href="{{ route('logout') }}">Logout</a>
                    @endauth
                </div>
            </nav>
        </header>
        <section id="home">
            <div class="container" id="#home">
                <article class="card">
                    <div class="background">
                        <img src="{{ asset('event/' . $user->avatar ?? '-') }}" alt="Avatar user" class="image">
                    </div>
                    <div class="content">
                        <h2>{{ $siswa->name }}</h2>
                        <p>Alamat : {{$siswa->alamat ?? '-' }} <br> Dari Jurusan {{$siswa->jurusans->kompetensi_keahlian}}</p>
                        <p>Status : </p>
                        <ul class="chips">
                            <li class="chip">{{ $siswa->status_siswa }}</li>
                            <li class="chip">{{ \Carbon\Carbon::parse($siswa->tanggal_lulus)->format('d-m-Y') }}</li>
                            <li class="chip details">Nomor induk sekolah : {{ $siswa->nis }}</li>
                            <li class="chip details">Nomor induk sekolah nasional : {{ $siswa->nisn }}</li>
                            <li class="chip details">Tanggal lahir : {{ $siswa->tanggal_lahir }}</li>
                            <li class="chip details">Orang tua : {{ $siswa->nama_orang_tua }}</li>
                        </ul>
                        <div class="tombol-aksi">
                            <button id="toggleButton" type="button" class="secondary" onclick="toggleDetails()">
                                <i class="fa-solid fa-magnifying-glass"></i> Lihat
                            </button>
                        </div>
                    </div>
                </article>
            </div>
        </section>
        <section id="karir">
            <div class="carousel-container">
                <div class="carousel">
                    <div class="carousel-inner">
                        @if ($siswa->karirs->isEmpty())
                            <div class="carousel-slide">
                                <article class="card-karir">
                                    <div class="background-karir">
                                        <img src="{{ asset('event/default.jpg') }}" alt="Lokasi karir" class="image">
                                    </div>
                                    <div class="content-karir">
                                        <h2>Data Karir</h2>
                                        <p>Data karir belum tersedia. <br> Silakan tambahkan data karir.</p>
                                        <ul class="chips-karir">
                                            <li class="chip-karir">Profesi: -</li>
                                            <li class="chip-karir">Bidang: -</li>
                                            <li class="chip-karir">-</li>
                                            <li class="chip-karir">Email: -</li>
                                            <li class="chip-karir">Nomor Telp.: -</li>
                                            <li class="chip-karir">Pendapatan per bulan: -</li>
                                        </ul>
                                        <div class="tombol-aksi-karir">
                                            <a href="{{ route('siswa.form_karir', [$user->slug]) }}"><i class="fa-solid fa-pen-to-square"></i> Update Data</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @else
                            @foreach ($siswa->karirs as $index => $karir)
                                <div class="carousel-slide">
                                    <article class="card-karir">
                                        <div class="background-karir">
                                            <img src="{{ asset('event/' . ($karir->foto_tempat)) }}" alt="Lokasi karir" class="image">
                                        </div>
                                        <div class="content-karir">
                                            <h2>Data Karir</h2>
                                            <p>Saat ini sedang {{ $karir->jenis_karir ?? '-' }} <br> di {{ $karir->nama_tempat ?? '-' }} <br> di {{ $karir->alamat_karir ?? '-' }}</p>
                                            <p>Status:</p>
                                            <ul class="chips-karir">
                                                <li class="chip-karir">{{ $karir->profesi ?? '-' }}</li>
                                                <li class="chip-karir">{{ $karir->bidang ?? '-' }}</li>
                                                <li class="chip-karir">{{ $karir->created_at->format('d-m-Y') }}</li>
                                                <li class="chip-karir">Email: {{ $karir->email ?? '-' }}</li>
                                                <li class="chip-karir">Nomor Telp.: {{ $karir->no_telp ?? '-' }}</li>
                                                <li class="chip-karir">Pendapatan per bulan: Rp. {{ number_format($karir->pendapatan, 0, ',', '.') }}</li>
                                            </ul>
                                            <div class="tombol-aksi-karir">
                                                <a href="{{ route('siswa.form_karir', [$user->slug]) }}"><i class="fa-solid fa-pen-to-square"></i> Update Data</a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button class="carousel-control prev">‹</button>
                    <button class="carousel-control next">›</button>
                </div>
            </div>
        </section>
        <section>
            <div class="container-grafik" id="karir">
                <canvas id="pendapatanChart" width="400" height="200"></canvas>
            </div>
        </section>
    </div>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- <script src="//js.pusher.com/3.1/pusher.min.js"></script> -->
    <script>
        var detailsElements = document.querySelectorAll('.details');
        detailsElements.forEach(function(element) {
            element.style.display = 'none';
        });

        function toggleDetails() {
            var detailsElements = document.querySelectorAll('.details');
            var toggleButton = document.getElementById('toggleButton');
            detailsElements.forEach(function(element) {
                if (element.style.display === 'none' || element.style.display === '') {
                    element.style.display = 'block';
                } else {
                    element.style.display = 'none';
                }
            });
            if (toggleButton.innerHTML.includes('Lihat')) {
                toggleButton.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> Sembunyikan';
            } else {
                toggleButton.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> Lihat';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const menuIcon = document.querySelector('.menu-icon');
            const navDropdown = document.querySelector('.nav-dropdown');
            const notificationIcon = document.getElementById('notificationIcon');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationList = document.getElementById('notificationList');
            let notificationCount = 0;

            menuIcon.addEventListener('click', function () {
                if (navDropdown.style.display === 'none') {
                    navDropdown.style.display = 'block';
                } else {
                    navDropdown.style.display = 'none';
                }
            });

            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true
            });

            var channel = pusher.subscribe('notifikasi-channel');
            
            function showToast(message) {
                var toastContainer = document.getElementById('toast-container');
                var toast = document.createElement('div');
                toast.className = 'toast show';
                toast.innerHTML = message;
                toastContainer.appendChild(toast);
                setTimeout(function() {
                    toast.classList.remove('show');
                    setTimeout(function() {
                        toast.remove();
                    }, 300);
                }, 10000);
            }

            function addNotification(message) {
                var li = document.createElement('li');
                li.textContent = message;
                notificationList.appendChild(li);

                notificationCount++;
                document.querySelector('.dot').classList.add('active');
                document.querySelector('.dot').setAttribute('data-count', notificationCount);
            }

            notificationIcon.addEventListener('click', function() {
                if (notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '') {
                    notificationDropdown.style.display = 'block';
                    var dot = document.querySelector('.dot');
                    dot.setAttribute('data-count', '0');
                    dot.style.display = 'none';
                } else {
                    notificationDropdown.style.display = 'none';
                }
            });

            channel.bind('notifikasi-event', function(data) {
                console.log('Event Received:', data.message);
                showToast(data.message);
                addNotification(data.message);
            });

            document.querySelectorAll('.carousel__navigation-button').forEach(button => {
                button.addEventListener('click', event => {
                    event.preventDefault();
                    const targetSlide = event.target.getAttribute('href').substring(1);
                    document.getElementById(targetSlide).scrollIntoView({ behavior: 'smooth' });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('pendapatanChart').getContext('2d');
            var pendapatanData = @json($pendapatanData);
            var labels = pendapatanData.map(data => data.tahun);
            var dataPendapatan = pendapatanData.map(data => data.pendapatan);
            var pendapatanChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: dataPendapatan,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: true,
                            text: 'Grafik data Penghasilan Alumni',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentIndex = 0;
            const slides = $('.carousel-slide');
            const totalSlides = slides.length;

            function showSlide(index) {
                if (index >= 0 && index < totalSlides) {
                    const offset = -index * 100;
                    $('.carousel-inner').css('transform', 'translateX(' + offset + '%)');
                    currentIndex = index;
                }
            }

            $('.next').click(function() {
                const nextIndex = (currentIndex + 1) % totalSlides;
                showSlide(nextIndex);
            });

            $('.prev').click(function() {
                const prevIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                showSlide(prevIndex);
            });

            showSlide(currentIndex);
        });
    </script>
</html>