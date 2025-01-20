<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PDF</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    </head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        h1 {
            font-family: Times New Roman, serif;
            font-size: 14px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        thead{
            background-color: yellow;
            color: #212121;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .header{
            padding: 0%;
            margin: 0%;
        }
        .header h2{
            padding: 0%;
            margin: 0%;
        }
        .header{
            padding: 0%;
            margin: 0%;
        }
        .pdf-table{
            width: 100%;
            border-collapse: collapse;
        }
        .pdf-table th, .pdf-table td{
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        .table-danger{
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        .pdf-table, .pdf-table tr, .pdf-table td{
            page-break-inside: avoid !important;
        }
        .container-body {
            /* page-break-after: always; */
            page-break-after: auto;
        }
        img{
            width: 45px;
            height: 35px;
            margin-left: 2%;
            padding-left: 2%;
            margin-bottom: 5px;
        }
    </style>
    <body class="main-content">
        @php $no = 1; @endphp
        @foreach($chunks as $chunk)
            <div style="text-align: center;" class="header">
                <img src="{{ $base64Image }}" alt="logo" height="45px">
                <h2>Sistem Informasi Alumni | SMK Negeri 2 Sampang</h2>
                <hr>
                <p>Jl. Syamsul Arifin, No. 69214, Kec. Sampang, Kab. Sampang</p>
            </div><br>
            <div class="container-body">
                <h2>Data Alumni Tahun Lulus {{ $tahunLulus }}</h2>
                <table class="pdf-table" cellpadding="2" cellspacing="0">
                    <thead>
                        <tr class="table-danger">
                            <th scope="col">#</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">NIS</th>
                            <th scope="col">NISN</th>
                            <th scope="col">Tanggal lahir</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Orang Tua / Wali</th>
                            <th scope="col">Tahun Lulus</th>
                            <th scope="col">Profesi</th>
                            <th scope="col">Bidang Profesi</th>
                            <th scope="col">Tempat Berkarir</th>
                            <th scope="col">Jenis Profesi</th>
                            <th scope="col">Pendapatan</th>
                            <th scope="col">Alamat karir</th>
                            <th scope="col">Tempat tinggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chunk as $alumni)
                            @php $karirCount = $alumni->karirs->count(); @endphp
                            @if($karirCount > 0)
                                @foreach($alumni->karirs as $index => $karir)
                                    <tr>
                                        @if($index == 0)
                                            <td rowspan="{{ $karirCount }}">{{ $no++ }}</td>
                                            <td rowspan="{{ $karirCount }}">{{ $alumni->jurusans->kompetensi_keahlian ?? '-' }}</td>
                                            <td rowspan="{{ $karirCount }}">{{ $alumni->name ?? '-' }}</td>
                                            <td rowspan="{{ $karirCount }}">{{ $alumni->nis ?? '-' }}</td>
                                            <td rowspan="{{ $karirCount }}">{{ $alumni->nisn ?? '-' }}</td>
                                            <td rowspan="{{ $karirCount }}">{{ \Carbon\Carbon::parse($alumni->tanggal_lahir)->format('d-m-Y') ?? '-' }}</td>
                                            <td rowspan="{{ $karirCount }}">{{ $alumni->alamat ?? '-' }}</td>
                                            <td rowspan="{{ $karirCount }}">{{ $alumni->nama_orang_tua ?? '-' }}</td>
                                            <td rowspan="{{ $karirCount }}" style="text-align: center;">{{ \Carbon\Carbon::parse($alumni->tanggal_lulus)->format('Y') ?? '-' }}</td>
                                        @endif
                                        <td>{{ $karir->profesi ?? '-' }}</td>
                                        <td>{{ $karir->bidang ?? '-' }}</td>
                                        <td>{{ $karir->nama_tempat ?? '-' }}</td>
                                        <td>{{ $karir->jenis_karir ?? '-' }}</td>
                                        <td>Rp. {{ number_format($karir->pendapatan, 0, ',', '.') ?? '-' }}</td>
                                        <td>{{ $karir->alamat_karir ?? '-' }}</td>
                                        <td>{{ $karir->tempat_tinggal ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $alumni->jurusans->kompetensi_keahlian ?? '-' }}</td>
                                    <td>{{ $alumni->name ?? '-' }}</td>
                                    <td>{{ $alumni->nis ?? '-' }}</td>
                                    <td>{{ $alumni->nisn ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($alumni->tanggal_lahir)->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $alumni->alamat ?? '-' }}</td>
                                    <td>{{ $alumni->nama_orang_tua ?? '-' }}</td>
                                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($alumni->tanggal_lulus)->format('Y') ?? '-' }}</td>
                                    <td colspan="7" style="text-align: center;">Data Karir belum tersedia</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Page Break untuk halaman berikutnya -->
            @if(!$loop->last)
                <div style="page-break-after: always;"></div>
            @endif
            <br>
        @endforeach
    </body>
</html>