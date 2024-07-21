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
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
    <body>
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <style>
            .add-data-btn, .edit-btn, .delete-btn, .back-btn {
                padding: 10px;
                background-color: #017DFA;
                color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                font-size: 11px;
                text-decoration: none;
                margin-right: 10px;
            }
            .add-data-btn:hover, .edit-btn:hover, .delete-btn:hover, .back-btn:hover {
                background-color: #0f4b88;
            }
            .add-data-btn:active, .edit-btn:active, .delete-btn:active, .back-btn:active {
                background-color: #065AAE;
            }
            .delete-btn {
                background-color: #FA017D;
            }
            .delete-btn:hover {
                background-color: #880f4b;
            }
            .delete-btn:active {
                background-color: #AE065A;
            }
            /* ul{
                margin: 5px 5px;
                padding: 5px;
                border: 1px dashed rgba(20, 0, 50, 0.2);
                border-radius: 10px 15px;
            }
            li{
                background-color: #fff;
                padding: 10px;
                margin: 10px 50px 10px 50px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(20, 0, 50, 0.2);
            } */
        </style>
        <div class="container-body" id="container-body">
            <br>
            <div class="content">
                <h2>Jawaban Kuesioner - {{ $questionnaire->title }}</h2>
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Nama Pengguna</th>
                            <th>Nama Pertanyaan</th>
                            <th>Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($answers as $answer)
                            <tr>
                                <td style="border: 1px dashed #1B262C;">{{ $answer->user->name }}</td>
                                <td style="border: 1px dashed #1B262C;">{{ $answer->question->question_text }}</td>
                                <td style="border: 1px dashed #1B262C;">{{ is_array($answer->response_text) ? implode(', ', $answer->response_text) : $answer->response_text }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table><br>
                <div class="contain-btn">
                    <a href="{{ route('questionnaires.index') }}" role="button" class="back-btn">Kembali</a>
                </div>
            </div>
        </div>
    </body>
</div>