<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/filter.js') }}"></script>
    <title>Kuisioner</title>
</head>
<div>
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
    <body class="main-content">
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="content-kuis">
                <div class="questionnaire-list">
                    <ol class="responsive-list" style="--length: 5" role="list">
                        <li style="--i: 1">
                            <h3>{{ $questionnaire->title }}</h3>
                            <p>{{ $questionnaire->description }}</p><br>
                            <p><a href="{{ route('questionnaires.createQuestion', $questionnaire) }}">Buat Pertanyaan</a></p><hr>
                            <p><a href="{{ route('questionnaires.showQuestions', $questionnaire) }}">Lihat Pertanyaan-pertanyaan saat ini</a></p><hr>
                            <p><a href="{{ route('questionnaires.showAnswers', $questionnaire) }}">Lihat Jawaban dari pertanyaan</a></p><br>
                            <!-- <p><a href="{{ route('questionnaires.answer', $questionnaire) }}">Jawab Kuesioner</a></p><hr><br> -->
                        </li>
                    </ol>
                </div> <br>
                <div class="posisi">
                    <a href="{{ route('questionnaires.index') }}" role="button" class="back-btn">Kembali</a>
                </div>
            </div>
        </div>
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
            .questionnaire-list {
                margin: 0 auto;
                padding: 0 1rem;
                max-width: 1200px;
            }

            .responsive-list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
            }

            .responsive-list li {
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 1rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s, box-shadow 0.3s;
            }

            .responsive-list li:hover {
                transform: translateY(-5px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            }

            .responsive-list h4 {
                margin: 0;
                font-size: 1.25rem;
            }

            .responsive-list a {
                text-decoration: none;
                color: #017DFA;
                transition: color 0.3s;
            }

            .responsive-list a:hover {
                color: #065AAE;
            }

            @media (max-width: 600px) {
                .responsive-list {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </body>
</div>