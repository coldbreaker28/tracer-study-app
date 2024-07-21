<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hai {{ $user->name }}</title>
    <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/siswa-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
    <header>
        <h2 class="logo">Selamat datang</h2>
        <nav class="navigation">
            <a href="{{ route('siswa.index', [$user->slug]) }}" >Home</a>
            <a href="{{ route('siswa.index', [$user->slug]) }}" >Karir</a>
            <a href="#Event" class="active">Service</a>
            <br>
            @auth
                <span class="username">{{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}">Logout</a>
            @endauth
            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endguest
            <div class="menu-icon" id="menu"><i class="fa-solid fa-burger"></i></div>

            <div class="nav-dropdown" id="dropdown" style="display: none;">
                <a href="#home" >Home</a>
                <a href="#about" >About</a>
                @auth
                    <a href="{{ route('logout') }}">Logout</a>
                @endauth
            </div>
        </nav>
    </header>
    <section id="event">
        <div class="container" id="#Event">
            <article class="card-detail">
                <img src="{{ asset('event/' . $data->poster) }}" alt="Poster Acara" class="card-detail-image">
                <div class="card-detail-body">
                    <h3 class="card-title">{{ $data->judul }}</h3>
                    <p class="author-name">{{ $data->description }}</p>
                    <div class="card-author">
                        <div class="author-details-detail">
                            <span class="publish-date">{{ $data->updated_at->format('d-F-Y') }}</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('siswa.event', [$user->slug]) }}" role="button" title="kembali" class="post-btn-back"><i class="fa-solid fa-arrow-left"></i></a>
            </article>
        </div>
    </section>
</div>