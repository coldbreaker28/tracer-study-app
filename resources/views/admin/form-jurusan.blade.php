<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <title>Tambah Jurusan</title>
    </head>
    <body class="main-content">
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="form-container">
                <!-- <div class="title">Update Data Siswa</div> -->
                <div class="form-content">
                    <form action="{{ route('admin.jurusan.verify') }}" method="post">
                    @csrf
                        <h2 style="text-align: start;">Jurusan</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label class="details" for="kompetensi_keahlian">Nama Jurusan</label>
                                <input name="kompetensi_keahlian" type="text" placeholder="Isi data nama jurusan" required>
                                @error('kompetensi_keahlian')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="contain-btn">
                            <a href="{{ route('admin.laporan.jurusan') }}" role="button" class="back-btn">kembali</a>
                            <button type="submit" class="send-btn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const errorMessages = document.querySelectorAll(".error-message");
                errorMessages.forEach(function (errorMessages){
                    errorMessages.style.display = "flex";
                });
            });
        </script>
    </body>
</div>
