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
                <td style="border: 1px dashed #1B262C;">{{ $no++ }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $alumniItem->jurusans->kompetensi_keahlian }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $alumniItem->nis }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $alumniItem->nisn }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $alumniItem->name }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $alumniItem->tanggal_lahir ?? '-'}}</td>
                <td style="border: 1px dashed #1B262C;">{{ $alumniItem->alamat ?? '-'}}</td>
                <td style="border: 1px dashed #1B262C;">{{ $alumniItem->nama_orang_tua ?? '-'}}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($alumniItem->tanggal_lulus)->format('Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
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
    {{ $alumni->links() }}
</div>