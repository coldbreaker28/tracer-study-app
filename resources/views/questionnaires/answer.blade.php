<div>
    <!-- It is never too late to be what you might have been. - George Eliot -->
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
        <title>Kuisioner</title>
    </head>
    <style>
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
            text-align: center;
            margin-top: 20px;
        }

        .back-btn, .send-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }

        .back-btn:hover, .send-btn:hover {
            background-color: #45a049;
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
    <body>
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <br>
            <div class="content">
                <div class="form-content">
                    <h2>{{ $questionnaire->title }}</h2>
                    <form action="{{ route('questionnaires.submitAnswer', $questionnaire) }}" method="POST">
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
                            <a href="{{ route('questionnaires.index') }}" role="button" class="back-btn">Kembali</a>
                            <button type="submit" class="send-btn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</div>
