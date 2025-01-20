<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <script src="{{ asset('js/filter.js') }}"></script>
        <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
        <title>Dashboard</title>
    </head>
    <body class="main-content">
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="content">
                <h2>Tabel Data Alumni</h2><hr>
                <div class="contain-input-search">
                    <form action="{{ route('admin.dashboard') }}" method="get" class="search-filter">
                        <label for="search">Cari Data Alumni : </label>
                        <input type="text" placeholder="Masukkan nama atau NIS" class="filter-cari" name="search" id="search"/>
                        <button type="submit" class="filter-btn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            Cari
                        </button><hr>
                    </form>
                </div><br>
                <div class="grup-header">
                    <div class="filter-container">
                        <form action="{{ route('admin.dashboard') }}" method="get">
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
                
                <!-- PAginasion  -->
                <div id="dashboard-container">
                    @include('superadmin.partials.dashboard')
                </div>
            </div>
            <div class="grup-chart">
                <div class="chart-card-dasbord">
                    <label>Statistik Status Lulusan</label><hr>
                    <canvas id="karirStatisticsChart"></canvas>
                </div>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('dataCompletionChart').getContext('2d');
            var data = @json($data_siswa);
            
            var labels = ['Data Lengkap', 'Data Tidak Lengkap'];
            var dataset = [data.siswas.withoutNull, data.siswas.withNull];

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: dataset,
                            backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                            borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Persentase Pengisian Data Siswa'
                        }
                    }
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
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.addEventListener("click", function (e) {
                if (e.target.tagName === "A" && e.target.closest(".pagination-links")) {
                    e.preventDefault();
                    const url = e.target.getAttribute("href");

                    fetch(url, {
                        headers: { "X-Requested-With": "XMLHttpRequest" },
                    })
                        .then((response) => response.text())
                        .then((html) => {
                            document.querySelector("#dashboard-container").innerHTML = html;
                        })
                        .catch((error) => console.error("Error:", error));
                }
            });
        });
    </script>
</html>