<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <script src="{{ asset('js/filter.js') }}"></script>
        <title>Dashboard</title>
    </head>
    <style>
        .grup-tabel{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        input[type="file"] {
            outline: none;
            padding: 4px;
            margin: -5px;
            color: #0964b0;
        }

        input[type="file"]:focus-within::file-selector-button,
        input[type="file"]:focus::file-selector-button {
            outline: 2px solid #0964b0;
            outline-offset: 2px;
        }
        input[type="file"]::before {
            top: 13px;
        }
        input[type="file"]::after {
            top: 11px;
        }

        input[type="file"] {
            position: relative;
        }
        input[type="file"]::before {
            position: absolute;
            pointer-events: none;
            left: 40px;
            color: #0964b0;
            content: "Upload File CSV:";
        }

        input[type="file"]::after {
            position: absolute;
            pointer-events: none;
            left: 16px;
            height: 20px;
            width: 20px;
            content: "";
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%230964B0'%3E%3Cpath d='M18 15v3H6v-3H4v3c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3h-2zM7 9l1.41 1.41L11 7.83V16h2V7.83l2.59 2.58L17 9l-5-5-5 5z'/%3E%3C/svg%3E");
        }
        input[type="file"]::file-selector-button:hover {
            background-color: #f3f4f6;
        }
        input[type="file"]::file-selector-button:active {
            background-color: #e5e7eb;
        }
        input[type="file"]::file-selector-button {
            width: 155px;
            color: transparent;
        }
        input[type="file"]::file-selector-button {
            border-radius: 4px;
            padding: 0 16px;
            height: 35px;
            cursor: pointer;
            background-color: white;
            border: 1px solid rgba(0, 0, 0, 0.16);
            box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.05);
            margin-right: 16px;
            transition: background-color 200ms;
        }
        .csv-grup{
            padding: 0px 15px 0px 15px;
            display: flex;
            flex-wrap: nowrap;
        }
        .csv-grup button[type="submit"] {
            padding: 10px;
            margin-left: 3%;
            color: #FFFFFF;
            background-color: #00ce33;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            font-size: 12px;
            display: flex;
            align-items: center;
        }
        .csv-grup button[type="submit"]:hover, .csv-grup button[type="submit"]:active{
            background-color: #0f9731;
        }
        i.fa-solid{
            padding: 0px 8px 0px 0px;
        }
        @supports (-moz-appearance: none) {
            input[type="file"]::file-selector-button {
                color: #0964b0;
            }
        }
    </style>
    <body class="main-content">
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="content">
                <h2>Tabel Data admin</h2><hr>
                <table class="responsive-table daftar-table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Level</th>

                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userAll as $item)
                            @if($item->level == 'admin')
                                <tr>
                                    <td style="border: 1px dashed #1B262C;">{{ $loop->iteration }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->name }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->email }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->level }}</td>
                                    <td style="text-align:center;" class="aksi-btn">
                                        <a href="{{route('admin.data-user.ditel', [$item->id,$item->slug])}}" title="Lihat Detail" role="button" class="read-btn"><i class="bi bi-eye"></i>Detail</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="content">
                <h2>Tabel Data user: Alumni</h2><hr>
                <table class="responsive-table daftar-table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Level</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($userAll as $item)
                            @if($item->level == 'siswa')
                                <tr>
                                    <td style="border: 1px dashed #1B262C;">{{ $no++ }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->name }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->email }}</td>
                                    <td style="border: 1px dashed #1B262C;">{{ $item->level }}</td>
                                    <td style="text-align:center;" class="aksi-btn">
                                        <a href="{{route('admin.data-user.ditel', [$item->id,$item->slug])}}" title="Lihat Detail" role="button" class="read-btn"><i class="bi bi-eye"></i>Detail</a>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table> <br>
                <div class="grup-tabel">
                    <a class="add-data-btn" href="{{ route('admin.create') }}"><i class="fa-solid fa-user"> | </i>Tambah Data</a>
                    <form action="{{ route('admin.import.csv') }}" method="post" enctype="multipart/form-data" class="csv-grup">
                        @csrf
                        <input type="file" name="csv_file" id="csv_file" required>
                        <button type="submit" title="Export to Excel"><i class="fa-solid fa-file-excel"></i>Import</button>
                    </form>
                    @if (session('success'))
                        <p>{{ session('success') }}</p>
                    @endif
                    @if (session('error'))
                        <p>{{ session('error') }}</p>
                    @endif
                </div>
                <style>
                    .pagination-links nav{
                        display: flex;
                        justify-content: center;
                        margin-top: 20px;
                    }
                    .pagination-links .pagination{
                        display: flex;
                        list-style: none;
                        padding: 0;
                        font: 12px bold;
                    }
                    .pagination-links .pagination li{
                        margin: 0 0px;
                    }
                    .pagination-links .pagination li a,
                    .pagination-links .pagination li span {
                        display: block;
                        padding: 5px 8px;
                        /* color: #007bff; */
                        color: #252525;
                        text-decoration: none;
                        border: 1px solid #dee2e6;
                        border-radius: 5px;
                    }

                    .pagination-links .pagination li a:hover,
                    .pagination-links .pagination li span.current {
                        background-color: #007bff;
                        color: #fff;
                    }
                </style>
                <div class="pagination-links">
                    {{ $userAll->links() }}
                </div>
            </div>
        </div>
    </body>
</html>