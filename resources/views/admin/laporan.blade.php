<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <script src="{{ asset('js/sidebar.js') }}"></script>
        <script src="{{ asset('js/filter.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Rekap Data Alumni</title>
    </head>
    <body class="main-content">
    @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <!-- <hr> --> 
            <div class="content">
                <h3>Data Alumni</h3>
                <table class="responsive-table-alumni daftar-table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">NIS</th>
                            <th scope="col">NISN</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Orang Tua/Wali</th>
                            <th scope="col">Tahun Lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumni as $alumniItem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $alumniItem->jurusans->kompetensi_keahlian }}</td>
                                <td>{{ $alumniItem->nis }}</td>
                                <td>{{ $alumniItem->nisn }}</td>
                                <td>{{ $alumniItem->name }}</td>
                                <td>{{ $alumniItem->tanggal_lahir ?? '-'}}</td>
                                <td>{{ $alumniItem->alamat ?? '-'}}</td>
                                <td>{{ $alumniItem->nama_orang_tua ?? '-'}}</td>
                                <td style="text-align: center;">{{ \Carbon\Carbon::parse($alumniItem->tanggal_lulus)->format('Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Tabel Jurusan -->

            <div class="card-container">
                <div class="card-multimedia">
                    <h3 style="text-align: center;">D.K.V.</h3><hr>
                    <p>Total Alumni D.K.V. saat ini : {{ $alumniPerKomli['Desain Komunikasi Visual'] ?? '0' }}</p>
                    <p>Dari Total Alumni Saat ini : {{ $totalAlumni }}</p>
                </div>
                <div class="card-otomotif">
                    <h3 style="text-align: center;">T. K. R. O.</h3><hr>
                    <p class="content-card">Total Alumni T. K. R. O. saat ini : {{ $alumniPerKomli['Teknik Kendaraan Ringan Otomotif'] ?? '0' }}</p>
                    <p>Dari Total Alumni Saat ini : {{ $totalAlumni }}</p>
                </div>
                <div class="card-agrobisnis">
                    <h3 style="text-align: center;">A. P. H. P.</h3><hr>
                    <p class="content-card">Total Alumni A. P. H. P. saat ini : {{ $alumniPerKomli['Agrobisnis Pengolahan Hasil Pertanian'] ?? '0' }}</p>
                    <p>Dari Total Alumni Saat ini : {{ $totalAlumni }}</p>
                </div>
                <div class="card-Mesin">
                    <h3 style="text-align: center;">Teknik Mesin</h3><hr>
                    <p class="content-card">Total Alumni Teknik Mesin saat ini : {{ $alumniPerKomli['Teknik Pemesinan'] ?? '0' }}</p>
                    <p>Dari Total Alumni Saat ini : {{ $totalAlumni }}</p>
                </div>
                <div class="card-Las">
                    <h3 style="text-align: center;">Teknik Las</h3><hr>
                    <p class="content-card">Total Alumni Teknik Las saat ini : {{ $alumniPerKomli['Teknik Pengelasan'] ?? '0' }}</p>
                    <p>Dari Total Alumni Saat ini : {{ $totalAlumni }}</p>
                </div>
            </div>
            <div class="chart-card">
                <h3>Data Grafik alumni dengan kompetensi keahlian</h3><hr>
                <canvas id="pengisianData" width="400" height="200"></canvas>
            </div>
        </div>
        <script>
            var ctx = document.getElementById('pengisianData').getContext('2d');
            var grafikData = @json($grafikData);
            var pengisianData = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: grafikData.labels,
                    datasets: grafikData.datasets
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Tahun Lulus'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: @json($totalAlumni),
                            title: {
                                display: true,
                                text: 'Persentase jumlah alumni per jurusan (%)'
                            }
                        }
                    },
                    plugins: {
                        legend : {
                            display: true,
                            position: 'right'
                        }
                    }
                }
            });
        </script>
        </div>
    </body>
</html>