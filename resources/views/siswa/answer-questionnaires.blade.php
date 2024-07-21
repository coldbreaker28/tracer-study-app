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
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
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
            padding: 8px 15px;
            background-color: #017DFA;
            color: #fff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            font-size: 12px;
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .back-btn:hover {
            background-color: #EB3B5A;
        }
        .form-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-content h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .question {
            margin-bottom: 20px;
        }

        .question label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        .question input[type="text"],
        .question textarea,
        .question select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-check {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            /* margin-top: 10px; */
        }

        .form-check-input {
            margin-right: 10px;
        }
        .form-check-label {
            margin-top: 10px;
        }

        .contain-btn {
            text-align: start;
            margin-top: 20px;
        }
        @media (max-width: 600px) {
            .container-body {
                padding: 15px;
            }

            .back-btn, .send-btn {
                width: 100%;
                margin-top: 10px;
            }
        }
    </style>
    <section id="kuis">
        <div class="container-kuis" id="Event">
            <div class="content">
            <div class="form-content">
                    <h2>{{ $questionnaire->title }}</h2>
                    <form action="{{ route('siswa.submit-questionnaires-answer', [$user->slug, $questionnaire]) }}" method="POST">
                        @csrf
                        @foreach($questionnaire->questions as $question)
                            <div class="question">
                                <label>{{ $question->question_text }}</label>
                                @if($question->question_type == 'text')
                                    <input type="text" name="{{ $question->id }}" class="form-control" required>
                                @elseif($question->question_type == 'radio' || $question->question_type == 'checkbox')
                                    @foreach(explode(',', $question->options) as $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="{{ $question->question_type }}" name="{{ $question->id }}[]" value="{{ $option }}">
                                            <label class="form-check-label">{{ $option }}</label>
                                        </div>
                                    @endforeach
                                @elseif($question->question_type == 'dropdown')
                                    <select name="{{ $question->id }}" class="form-control" required>
                                        @foreach(explode(',', $question->options) as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        @endforeach
                        
                        <div class="contain-btn">
                            <a href="{{ route('siswa.questionnaires-show', [$user->slug, $questionnaire]) }}" role="button" class="back-btn">Kembali</a>
                            <button type="submit" class="add-data-btn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>