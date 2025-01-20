<table class="responsive-table daftar-table">
    <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Kompetensi Keahlian</th>
            <th scope="col">Nama Lengkap</th>
            <th scope="col">NIS</th>
            <th scope="col">NISN</th>
            <th scope="col">Tahun Lulus</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alumni as $item)
            <tr>
                <td style="border: 1px dashed #1B262C;">{{ $no++ }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $item->jurusans->kompetensi_keahlian }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $item->users->name }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $item->nis }}</td>
                <td style="border: 1px dashed #1B262C;">{{ $item->nisn }}</td>
                <td style="border: 1px dashed #1B262C;">{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('Y') }}</td>
                <td class="aksi-btn">
                    <a  href="{{ route('admin.detail', [$item->slug]) }}" role="button" class="read-btn" title="Lihat Detail"><i class="bi bi-eye"></i>Detail</a>
                    <!-- <a href="{{ route('admin.edit', [$item->slug]) }}" role="button" class="update-btn" title="Edit Data"><i class="bi bi-pencil-square"></i>Update</a> -->
                    <form action="{{ route('admin.destroy', [$item->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" title="Hapus Data"><i class="bi bi-trash"></i>Hapus</button>
                    </form>
                </td>
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