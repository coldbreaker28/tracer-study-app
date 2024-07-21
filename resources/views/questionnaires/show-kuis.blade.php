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
    <!-- An unexamined life is not worth living. - Socrates -->
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
                <div class="form-content">
                    <h2>{{ $questionnaire->title }}</h2>
                    <p>{{ $questionnaire->description }}</p>
                    <hr>
                    <h3>Pertanyaan:</h3>
                    <ul>
                        @foreach($questionnaire->questions as $question)
                            <li>
                                <strong>{{ $question->question_text }}</strong> ({{ ucfirst($question->question_type) }})
                                @if($question->question_type != 'text')
                                    <br>
                                    <strong>Opsi:</strong> {{ implode(', ', explode(',', $question->options)) }}
                                @endif
                                <br>
                                <a href="{{ route('questions.editQuestion', $question) }}" class="edit-btn">Edit</a>
                                <form action="{{ route('questions.destroyQuestion', $question) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">Hapus</button>
                                </form>
                            </li>
                            <!-- <hr> -->
                        @endforeach
                    </ul>
                    <br>
                    <a href="{{ route('questionnaires.createQuestion', $questionnaire) }}" class="add-data-btn">Tambah Pertanyaan Baru</a>
                    <br><br>
                    <a href="{{ route('questionnaires.index') }}" class="back-btn">Kembali ke Daftar Kuesioner</a>
                </div>
            </div>
        </div>
    </body>
</div>