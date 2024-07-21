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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <script src="{{ asset('js/sidebar.js') }}"></script>
        <script src="{{ asset('js/filter.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Statis Karir Alumni</title>
    </head>
    <style>
        .head-content{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
        }
        .read-btn {
            background-color: #0A7FE6;
            /* color: #2B2B2B; */
            color: #fff;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 5px 10px rgba(148, 0, 255, 0.1);
        }

        .read-btn:hover, .read-btn:active {
            background-color: #0c70c7;
            cursor: pointer;
        }
        form{
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
        }
        .nama {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
            margin: 0px 10px 0px 10px;
            /* margin: 5px; */
        }

        .nama label {
            font-size: 14px;
            font-weight: bold;
            width: auto;
            z-index: 10;
            margin-right: 10px;
        }
        .nama select{
            border-radius: 8px;
            border: 1px solid rgba(60, 15, 85, 0.2);
            box-shadow: 2px 2px 3px rgba(60, 15, 85, 0.1);
            padding: 5px 3px 5px 5px;
            cursor: pointer;
        }
    </style>
    <body class="main-content">
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div id="konten">
                <div class="content">
                    <div class="head-content">
                        <h3>Data Alumni dengan Karir</h3>
                        <!-- <button class="read-btn" onclick="downloadPDF()"><i class="fa-solid fa-file-pdf"></i> Download PDF</button> -->
                        <!-- <a href="{{ route('admin.sheet.get') }}" class="read-btn" role="button" title="Export to PDF"><i class="fa-solid fa-file-pdf"> | </i> ekspor ke PDF</a> -->
                        <form action="{{ route('admin.sheet.pdf') }}" method="get">
                            <div class="nama">
                                <label for="tahun_lulus">Pilih Tahun Lulus alumni:</label><br>
                                <select name="tahun_lulus" id="tahun_lulus">
                                    <option value="all">Semua Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year ?? '-'}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="nama">
                                <label for="bidang">Pilih Bidang Karir:</label><br>
                                <select name="bidang" id="bidang">
                                    <option value="all">Semua Bidang</option>
                                    @foreach($bidangKarirList as $bidang)
                                        <option value="{{ $bidang }}">{{ $bidang ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="read-btn" type="submit"><i class="fa-solid fa-file-pdf"> | </i> Ekspor PDF </button>
                        </form>
                        <!-- <form action="{{ route('admin.sheet.get') }}" method="get">
                            <div class="nama">
                                <label for="tahun_lulus">Pilih Tahun Lulus alumni:</label><br>
                                <select name="tahun_lulus" id="tahun_lulus">
                                    <option value="all">Semua Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year ?? '-'}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="nama">
                                <label for="bidang">Pilih Bidang Karir:</label><br>
                                <select name="bidang" id="bidang">
                                    <option value="all">Semua Bidang</option>
                                    @foreach($bidangKarirList as $bidang)
                                        <option value="{{ $bidang }}">{{ $bidang ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="read-btn" type="submit"><i class="fa-solid fa-file-pdf"> | </i> Show PDF </button>
                        </form> -->
                    </div>                    
                    <hr>
                    <table class="responsive-table-output daftar-table">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">NISN</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Kompetensi Keahlian</th>
                                <th scope="col">Tahun Lulus</th>
                                <th scope="col">Perusahaan/Instansi</th>
                                <th scope="col">Profesi</th>
                                <th scope="col">Bidang</th>
                                <th scope="col">Jenis Karir</th>
                                <th scope="col">Alamat Karir yang Ditempuh</th>
                                <th scope="col">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumni as $item)
                                @php
                                    $karirCount = $item->karirs->count();
                                @endphp
                                @if ($karirCount > 0)
                                    @foreach ($item->karirs as $index => $karir)
                                        <tr>
                                            @if ($index == 0)
                                                <td rowspan="{{ $karirCount }}">{{ $no++ }}</td>
                                                <td rowspan="{{ $karirCount }}">{{ $item->nisn }}</td>
                                                <td rowspan="{{ $karirCount }}">{{ $item->name }}</td>
                                                <td rowspan="{{ $karirCount }}">{{ $item->jurusans->kompetensi_keahlian ?? '-' }}</td>
                                                <td rowspan="{{ $karirCount }}" style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('Y') }}</td>
                                            @endif
                                            <td>{{ $karir->nama_tempat ?? '-'}}</td>
                                            <td>{{ $karir->profesi ?? '-'}}</td>
                                            <td>{{ $karir->bidang ?? '-'}}</td>
                                            <td>{{ $karir->jenis_karir ?? '-'}}</td>
                                            <td>{{ $karir->alamat_karir ?? '-'}}</td>
                                            <td>Rp. {{ number_format($karir->pendapatan, 0, ',', '.' ?? '-') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->jurusans->kompetensi_keahlian ?? '-' }}</td>
                                        <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('Y') }}</td>
                                        <td colspan="6">Data karir tidak tersedia</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="chart-card">
                    <h3>Data Grafik Bidang Karier Alumni per Tahun Lulus </h3><hr>
                    <canvas id="grafikKarier" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </body>
    <script>
        var ctx = document.getElementById('grafikKarier').getContext('2d');
        var grafikData = @json($grafikData);
        var grafikKarier = new Chart(ctx, {
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
                        title: {
                            display: true,
                            text: 'Maksimal Data Karir per Bidang'
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
</html>