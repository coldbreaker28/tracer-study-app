<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <title>Detail Alumni</title>
    </head>
    <body class="main-content">
    @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="content">
                <h2>Detail Alumni</h2>
                <table class="responsive-table-detail">
                    <tr>
                        <th>Username : </th>
                        <td>{{ $userId->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email : </th>
                        <td>{{ $userId->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Level : </th>
                        <td>{{ $userId->level ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>password : </th>
                        <td contenteditable="true" data-id="{{ $userId->id }}" data-field="password">{{ str_repeat('*', 8) }}</td>
                    </tr>
                </table>
                <div class="posisi">
                    <a href="{{ route('admin.data-user') }}" role="button" class="back-btn">kembali</a>
                </div>
            </div>     
        </div>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[contenteditable]').forEach(cell => {
                cell.addEventListener('blur', function () {
                    const id = this.dataset.id;
                    const field = this.dataset.field;
                    const newValue = this.innerText;

                    fetch(`/admin/data-user/update/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            [field]: newValue,
                        }),
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Success:', data);
                    }).catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
</html>