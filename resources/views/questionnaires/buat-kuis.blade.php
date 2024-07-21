<div>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <script src="{{ asset('js/filter.js') }}"></script>
        <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
        <title>Kuisioner</title>
    </head>
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
    <body>
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <br>
            <div class="form-container">
                <div class="form-content">
                    <form method="POST" action="{{ route('questionnaires.storeQuestion', $questionnaire) }}" enctype="multipart/form-data">
                        @csrf
                        <h2 style="text-align: start;">Buat Pertanyaan di {{ $questionnaire->title }}</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label class="details" for="question_text">Pertanyaan</label>
                                <input name="question_text" type="text" placeholder="Pertanyaan..." required><br>
                                @error('question_text')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="question_type">Tipe Pertanyaan</label>
                                <select name="question_type" required>
                                    <option value="text">Teks</option>
                                    <option value="radio">Radio</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="dropdown">Dropdown</option>
                                </select>
                                @error('question_type')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="options">Opsi (pisahkan dengan koma)</label>
                                <input name="options" type="text" placeholder="Opsi..." required><br>
                                @error('options')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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