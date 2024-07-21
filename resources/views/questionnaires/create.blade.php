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
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
    <body>
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <br>
            <div class="form-container">
                <div class="form-content">
                    <form method="POST" action="{{ route('questionnaires.store') }}" enctype="multipart/form-data">
                        @csrf
                        <h2 style="text-align: start;">Buat Kuisioner baru</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label class="details" for="title">Judul</label>
                                <input name="title" type="text" placeholder="Judul Kuisioner..." required><br>
                                @error('title')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="description">Deskripsi</label>
                                <input name="description" type="text" placeholder="Deskripsi..." required><br>
                                @error('description')
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