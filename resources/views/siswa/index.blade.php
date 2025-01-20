<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/home-alumni.css') }}">
        <link rel="stylesheet" href="{{ asset('css/post.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <script src="{{ asset('js/filter.js') }}"></script>
        <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <title>Sistem Informasi Alumni</title>
    </head>
    <style>
        .logo-container{
            margin-right: 8px;
        }
        .logo-container img{
            width: 50px;
            height: 40px;
            /* margin-top: 10px; */
            margin-left: 2%;
            padding-left: 2%;
        }
        .logo{
            display: flex;
            flex-direction: row;
        }
    </style>
    <body> 
        <header>
            <h2 class="logo">
                <div class="logo-container">
                    <img src="{{ asset('images/70286974LOGOSMKN2SPG-600x527.PNG') }}" alt="logo">
                </div>
                Alumni
            </h2>
            <nav class="navigation">
                <a href="#home" >Menu Utama</a>
                <a href="#about" >Tentang</a>
                <a href="#service" >Mading</a>
                <!-- <a href="#contact" >Contact</a> -->
                <br>
                @auth
                    <span class="username" >{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}">Keluar</a>
                @endauth
                @guest
                    <!-- Tampilkan elemen ini jika pengguna belum login -->
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endguest
                <div class="menu-icon" id="menu"><i class="fa-solid fa-burger"></i></div>
                <!-- Dropdown -->
                <div class="nav-dropdown" id="dropdown" style="display: none;">
                    <a href="#home" >Menu Utama</a>
                    <a href="#about" >Tentang</a>
                    <a href="#service" >Mading</a>
                    @auth
                        <a href="{{ route('logout') }}">Logout</a>
                    @endauth
                </div>
            </nav>
        </header>

        <section id="home">
            <section class="parallax">
                <img src="{{ asset('parallax/Parallax 1.webp') }}" id="Parallax1" loading="lazy">
                <img src="{{ asset('parallax/Parallax 2-1.webp') }}" id="Parallax2" loading="lazy">
                <img src="{{ asset('parallax/Parallax 2-2.webp') }}" id="Parallax2" loading="lazy">
                <h2 id="text" style="color: white;">"Fokus Tujuan, Bukan Hambatan"</h2>
                <img src="{{ asset('parallax/Parallax 3-1.webp') }}" id="Parallax3" loading="lazy">
                <img src="{{ asset('parallax/Parallax 3-2.webp') }}" id="Parallax3" loading="lazy">
            </section>

            <section class="sec">
                <h2>Menu Utama</h2>
                <p>
                    "Akar dari pendidikan memang pahit, tapi buahnya manis. - Aristoteles<br>
                    Tindakan adalah kunci menuju kesuksesan dan Fokus pada tujuan, bukan hambatan."<br>
                    "Hiduplah seolah engkau mati besok. Belajarlah seolah engkau hidup selamanya. - Mahatma Gandhi<br>
                    Watukosek - Reuni adalah pertemuan mantan teman, biasanya diadakan di atau dekat tempat Pendidikan lama mereka oleh seorang anggota saat atau mendekati ulang tahun kelulusan mereka.<br>
                    Pendidikan adalah kunci untuk membuka gembok dunia, paspor untuk kebebasan." - Oprah Winfrey <br>
                </p>
                <div class="grup-chart">
                    <div class="chart-card-dasbord">
                        <label>Statistik Status Lulusan</label><hr>
                        <canvas id="karirStatisticsChart"></canvas>
                    </div>
                </div>
                <div class="content">
                    <style>
                        /* --- Tabel alumni --- */
                        .responsive-table-alumni {
                            flex-grow: 1;
                            width: 100%;
                            border-collapse: collapse;
                            border-radius: 15px;
                            
                        }
                        .responsive-table-alumni th{
                            text-align: left;
                            font-size: 11px;
                            padding: 8px;
                            background-color: #1B262C;
                            color: #FFFFFF;
                            border: 1px solid #1B262C;
                        }
                        .responsive-table-alumni td{
                            font-size: 9px;
                            padding: 8px;
                            text-align: left;
                            border: 1px dashed #1B262C;
                        }
                        .responsive-table-alumni tr:nth-child(even){
                            background-color: rgba(16, 185, 177,0.3);
                        }
                        .responsive-table-alumni tr:hover{
                            background-color: rgba(23, 231, 220, 0.5);
                        }
                        .content hr{
                            border: 1px solid #EDE5F2;
                            margin: 10px 0;
                        }
                        .content h3{
                            font-size: 14px;
                        }
                    </style>
                    <h4 style="color: #252525;">Tabel Data Alumni</h4>
                    <div class="grup-header">
                        <div class="filter-container">
                            <form action="{{ url('/') }}" method="get">
                                <label for="filter">Filter : </label>
                                <select name="filter" id="filter" onchange="this.form.submit()">
                                    <option value="">Pilih Filter</option>
                                    <option value="name_asc">&uarr; Nama siswa</option>
                                    <option value="name_desc">&darr; Nama siswa</i></option>
                                    <option value="kompetensi_asc">&uarr; Kompetensi Keahlian</option>
                                    <option value="kompetensi_desc">&darr; Kompetensi Keahlian</option>
                                    <option value="tahun_asc">&uarr; Tahun lulus</option>
                                    <option value="tahun_desc">&darr; Tahun lulus</option>
                                    <option value="terbaru">Terbaru</option>
                                    <option value="terakhir">Terakhir</option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <table class="responsive-table-alumni daftar-table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Kompetensi Keahlian</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">NIS</th>
                                <th scope="col">NISN</th>
                                <th scope="col">Tahun Lulus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($alumni as $item)
                                <tr>
                                    <td style="border: 1px dashed #1B262C;">{{ $no++ }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->jurusans->kompetensi_keahlian }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->users->name }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->nis }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->nisn }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- PAginasion  -->
                    <!-- <div class="pagination-links">
                        {{ $alumni->links() }}
                    </div> -->
                </div>
            </section>
        </section>

        <section id="about">
            <section class="sec2">
                <h2>Tentang </h2>
                <div class="sec2-body">
                    <div class="card-about">
                        <h3>Visi: </h3>
                        <p>
                            "Menjadi SMK bertaraf Internasional yang dapat mencetak tenaga Profesional Inovatif, Berbudaya, Berdaya saing global, Mampu mengembangkan sumber daya lokal, berbasis Imtaq dan Iptek serta berwawasan lingkungan"
                        </p>
                    </div>
                </div>
                <br>
                <div class="sec2-body">
                    <div class="card-about">
                        <h3>Misi:</h3>
                        <p>
                            1.	Menyiapkan tenaga kerja tingkat menengah untuk mengisi kebutuhan pembangunan baik di dalam dan  di luar negeri. <br>
                            2.	Membekali lulusan dengan keahlian profesi sebagai keunggulan <br>
                            3.	Menghasilkan lulusan yang mampu mandiri sehingga dapat mengembangkan kualitas dirinya secara berkelanjutan <br>
                            5.	Meningkatkan pelayanan kepada masyarakat pengguna jasa pendidikan <br>
                            6.	Mengembangkan kerjasama dengan Dunia Usaha/Dunia Industri untuk peningkatan kualitas dan pemasaran lulusan. <br>
                            7.	Meningkatkan kepedulian dan peran masyarakat dalam membangun pendidikan menengah kejuruan.  <br>
                            8.	Meningkatkan relevansi program sarana dan prasarana pendidikan menengah kejuruan agar dapat menyesuaikan dengan perkembangan IPTEK dan pasar kerja.  
                        </p>
                    </div>
                </div>
            </section>
        </section>

        <section id="service">
            <section class="sec2">
                <h2>Mading </h2>
                <div class="content">
                    <section class="media-scroller-container">
                        <div class="media-scroller">
                        @if($post->isEmpty())
                            <p>Data belum tersedia...</p>
                        @else
                            @foreach ($post as $event)
                                <article class="card">
                                    <img src="{{ asset('event/' . $event->poster) }}" alt="Poster Acara" class="card-image">
                                    <div class="card-body">
                                        <h3 class="card-title"><a href="{{ route('index.detail_mading', $event->id) }}">{{ $event->judul }}</a></h3>
                                        <div class="card-author">
                                            <div class="author-details">
                                                <span class="author-name">{{ $event->users->name }}</span>
                                                <span class="publish-date">{{ $event->created_at->format('d-F-Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        @endif
                        </div>
                    </section>
                </div>
            </section>
        </section>
        <section id="contact">
            <section class="sec3">
                <!-- <footer class="top">
                        <div class="links">
                            <div class="links-column">
                                <h2>Contact Us</h2>
                                <label>
                                    Saya : <br>
                                    +62 87838824255
                                </label>
                            </div>
                            <div class="links-column socials-column">
                                <h2>Social Media</h2>
                                <label>
                                    Follow us ....
                                </label>
                                <div class="socials">

                                    <a href="https://www.instagram.com/smekda.squad?igsh=cDhieXZ6MHlkenFv" class="fa-reguler fa-brands fa-instagram"></a>
                                    <a href="https://youtube.com/@smekda.official?si=-oyVUK15jSnJsD_H" class="fa-reguler fa-brands fa-youtube"></a>
                                </div>
                            </div>
                        </div>
                    </footer> -->
                    <footer class="bottom">
                        <p class="copyright">&copy; 2023 Not For Commercial</p>
                        <div class="legal">
                            <a>License</a>
                        </div>
                    </footer>
            </section>
        </section>
    </body>
    <script src="{{ asset('js/home-alumni.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuIcon = document.querySelector('.menu-icon');
            const navDropdown = document.querySelector('.nav-dropdown');

            menuIcon.addEventListener('click', function () {
                if (navDropdown.style.display === 'none') {
                    navDropdown.style.display = 'block';
                } else {
                    navDropdown.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('karirStatisticsChart').getContext('2d');
            var data = @json($jenis_karir);

            var labels = Object.keys(data);
            var values = Object.values(data);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
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
</html>