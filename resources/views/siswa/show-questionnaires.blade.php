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
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
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

        .back-btn {
            background-color: #fc3e48;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            box-shadow: 0 5px 10px rgba(148, 0, 255, 0.1);
        }
        .back-btn:hover {
            background-color: #EB3B5A;
        }
        
    </style>
    <section id="kuis">
        <div class="container-kuis" id="Event">
            <div class="content">
                <div class="questionnaire-list">
                    <ol class="responsive-list" style="--length: 5" role="list">
                        <li style="--i: 1">
                            <h3>{{ $questionnaire->title }}</h3>
                            <p>{{ $questionnaire->description }}</p><br><hr style="border: 1px solid #1F2030;"><br>
                            <p><a href="{{ route('siswa.questionnaires-answer', [$user->slug, $questionnaire]) }}">Jawab Kuesioner</a></p><br>
                            <a href="{{ route('siswa.event', [$user->slug]) }}" role="button" class="back-btn">Kembali</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
</div>