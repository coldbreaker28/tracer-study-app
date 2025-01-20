<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Dashboard Events</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
</head>
<body class="main-content">
    @include('components.navAdmin')
    @include('components.sidebarAdmin')
    <div class="container-body" id="container-body">
        <div class="content">
            <h2>Mading Poster</h2><hr>
            <section class="media-scroller-container">
                <div class="media-scroller">
                    @if($post->isEmpty())
                        <p>Data belum tersedia...</p>
                    @else
                        @foreach ($post as $event)
                            <article class="card">
                                <img src="{{ asset('event/' . $event->poster) }}" alt="Poster Acara" class="card-image">
                                <div class="card-body">
                                    <h3 class="card-title"><a href="{{ route('events.admin.detail', $event->id) }}">{{ $event->judul }}</a></h3>
                                    <div class="card-author">
                                        <img src="{{ asset('event/' .$event->users->avatar) }}" alt="Avatar User" class="author-image">
                                        <div class="author-details">
                                            <span class="author-name">{{ $event->users->name }}</span>
                                            <span class="publish-date">{{ $event->created_at->format('d-F-Y') }}</span>
                                        </div>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" role="button" title="Hapus Post" class="post-btn-destroy">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </article> 
                        @endforeach
                    @endif
                </div>
            </section>
            <!-- <br>
            <h1>Pusher Test Page</h1> -->
            <!-- <button style="cursor: pointer;" onclick="sendTestEvent()">Send Test Event</button> -->
            <!-- <a href="{{ route('send') }}" class="send-btn">Send it!</span></a> -->
        </div>
    </div>
</body>
<script>
    // const notif = document.getElementById('show-notification-button').addEventListener('click', function() {
    //     Swal.fire({
    //         title: 'Notifikasi Baru!',
    //         text: 'Poster Baru Berhasil Ditambahkan.',
    //         icon: 'success',
    //         showCancelButton: false,
    //         confirmButtonText: 'Tutup',
    //     });
    // });

    // function fetchNotifications() {
    // axios.get('acara/admin/dashboard')
    //     .then(function (response) {
    //         // Tangani data notifikasi yang Anda terima dari server
    //         const notifications = response.data;
    //         // Proses notifikasi dan tampilkan ke pengguna
    //     })
    //     .catch(function (error) {
    //         console.error(error);
    //     });
    // }

    // fetchNotifications();
</script>
</html>