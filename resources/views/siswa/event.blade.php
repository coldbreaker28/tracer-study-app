<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hai {{ $user->name }}</title>
    <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/siswa-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kuisioner.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
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
            <div class="content">
                <h2>Events</h2><hr>
                <section class="media-scroller-container">
                    <div class="media-scroller">
                        @foreach ($post as $event)
                            <article class="card">
                                <img src="{{ asset('event/' . $event->poster) }}" alt="Poster Acara" class="card-image">
                                <div class="card-body">
                                    <label style="font-weight: bold;" class="card-title"><a href="{{ route('siswa.event-detail', [$user->slug, $event->id]) }}">{{ $event->judul }}</a></label>
                                    <div class="card-author">
                                        <img src="{{ asset('event/' .$event->users->avatar) }}" alt="Avatar User" class="author-image">
                                        <div class="author-details">
                                            <span class="author-name">{{ $event->users->name }}</span>
                                            <span class="publish-date">{{ $event->created_at->format('d-F-Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
                <style>
                    .add-data-btn{
                        padding: 10px;
                        background-color: #017DFA;
                        color: #fff;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                        font-size: 11px;
                    }
                    .add-data-btn:hover{
                        background-color: #0f4b88;
                    }
                    .add-data-btn:active{
                        background-color: #065AAE;
                    }
                </style>
                <br><a href="{{ route('siswa.buat-mading', [$user->slug]) }}" type="button" class="add-data-btn">Buat baru</a>
            </div>
        </div>
    </section>
    <section id="kuis">
        <div class="container-kuis" id="Event">
            <div class="content">
                <h2>Daftar Kuesioner</h2><hr>
                <div class="questionnaire-list">
                    <ol class="responsive-list" style="--length: {{ count($questionnaires) }}" role="list">
                        @foreach($questionnaires as $index => $questionnaire)
                            <li style="--i: {{ $index + 1 }}">
                                <h4><a href="{{ route('siswa.questionnaires-show', [$user->slug, $questionnaire]) }}">{{ $questionnaire->title }}</a></h4>
                                
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section>
</div>