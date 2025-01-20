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
    {{ $userAll->links() }}
</div>