<div>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <title>Rekap Data Alumni</title>
    </head>
    <body class="main-content">
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <!-- <hr> --> 
            <!-- Tabel Jurusan -->
            <div class="content">
                <h3>Tabel Jurusan Sekolah</h3>
                <table class="responsive-table-jurusan daftar-table">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Jurusan</th>

                            <th >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jurusan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kompetensi_keahlian }}</td>

                                <td class="aksi-btn">
                                <a href="{{ route('admin.jurusan.edit',     [$item->id]) }}" role="button" class="update-btn" title="Edit Data"><i class="bi bi-pencil-square"></i>Update</a>
                                    <form action="{{ route('admin.jurusan.destroy',     [$item->id]) }}" method="post" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn" title="hapus"><i class="fa-solid fa-trash"></i>Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <a class="add-data-btn" href="{{ route('admin.jurusan.add') }}"><i class="fa-solid fa-book"> | </i>Tambah Data</a>
            </div>
        </div>
    </body>
</div>