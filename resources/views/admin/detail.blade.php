<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <script src="{{ asset('js/sidebar.js') }}"></script>
        <script src="{{ asset('js/filter.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Detail Alumni {{ $alumni->name ?? '-'}}</title>
    </head>
    <style>
        .container-grafik {
            display: flex;
            margin: 50px 0px 5px 0px;
            padding: 20px;
            position: relative;
            box-shadow: 2px 4px 5px rgba(2,0,25,0.3);
            background: white;
            border-radius: 20px;
            overflow: auto;
            scroll-snap-align: center;
            justify-content: center;
        }
        .container {
            display: flex;
            margin: 30px 55px 20px 55px;
            padding: 20px;
            position: relative;
            border: 1px dashed;
            box-shadow: 2px 4px 5px rgba(2, 0, 25, 0.2);
            background: white;
            border-radius:  20px 15px;
            overflow-x: auto;
            scroll-snap-align: center;
        }
        .image-profile {
            display: grid;
            flex: 0 0 14.5rem;
            grid-template-rows: 9.125rem 1fr;
            row-gap: 1rem;
            width: 50%;
            height: 50%;
            object-fit: cover;
            border-radius: 5px 5px;
            margin-right: 15px;
            overflow: hidden;
            box-shadow: 2px 4px 5px rgba(2,0,25,0.3);
        }
        .detail-siswa{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .baris{
            margin-top: 5px;
            margin-right: 5px;
        }
        .isi{
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            margin: 10px 12px 10px 10px;
            padding: 5px;
        }
    </style>
    <body class="main-content">
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="content">
                <h3>Detail Alumni</h3><hr>
                <div class="container">
                    <img src="{{ asset('event/'.  $userAlumni->avatar) }}" alt="Your_avatar" class="image-profile">
                    <article class="detail-siswa">
                        <div class="baris">
                            <h3>Data Alumni</h3><hr>
                            <div class="isi">
                                <h3>Nama: </h3>
                                <p>
                                    {{ $alumni->name ?? '-'}}
                                </p>
                            </div>
                            <div class="isi">
                                <h3>Tanggal Lahir : </h3>
                                <p>
                                    {{ $alumni->tanggal_lahir ?? '-' }}
                                </p>
                            </div>
                            <div class="isi">
                                <h3>Alamat: </h3>
                                <p>
                                    {{ $alumni->alamat ?? '-'}}
                                </p>
                            </div>
                            <div class="isi">
                                <h3>Nama Orang Tua : </h3>
                                <p>
                                    {{ $alumni->nama_orang_tua ?? '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="baris">
                            <br><hr>
                            <div class="isi">
                                <h3>Jurusan : </h3>
                                <p>
                                    {{ $alumni->jurusans->kompetensi_keahlian ?? '-' }}
                                </p>
                            </div>
                            <div class="isi">
                                <h3>Nomor Induk Sekolah : </h3>
                                <p>
                                    {{ $alumni->nis ?? '-' }}
                                </p>
                            </div>
                            <div class="isi">
                                <h3>Nomor Induk Sekolah Nasional : </h3>
                                <p>
                                    {{ $alumni->nisn ?? '-' }}
                                </p>
                            </div>
                            <div class="isi">
                                <h3>Tanggal Lulus : </h3>
                                <p>
                                    {{ $alumni->tanggal_lulus ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="posisi">
                    <a href="{{ route('admin.dashboard') }}" role="button" class="back-btn">kembali</a>
                </div>
            </div>
            <div class="carousel-container">
                <div class="carousel">
                    <div class="carousel-inner">
                        @if ($alumni->karirs->isEmpty())
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
                                    </div>
                                </article>
                            </div>
                        @else
                            @foreach ($alumni->karirs as $index => $karir)
                                <div class="carousel-slide">
                                    <article class="card-karir">
                                        <div class="background-karir">
                                            <img src="{{ asset('event/' . ($karir->foto_tempat ?? 'default.jpg')) }}" alt="Lokasi karir" class="image">
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
            <div class="container-grafik">
                <canvas id="pendapatanChart" width="400" height="200"></canvas>
            </div>
        </div>
    </body>
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