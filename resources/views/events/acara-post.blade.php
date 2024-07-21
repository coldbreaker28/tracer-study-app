<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->
        <title>Posting Acara</title>
    </head>
    <body class="main-content">
        
    @include('components.navAdmin')
    @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="form-container">
                <div class="form-content">
                    <form action="{{ route('events.post') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h2 style="text-align: start;">Unggah Poster</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label for="judul" class="details">Judul Poster</label>
                                <input type="text" name="judul" id="judul" placeholder="Judul Postingan..." required><br>
                                @error('judul')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label for="jenis" class="details">Jenis Postingan</label>
                                <select name="jenis" id="jenis" aria-placeholder="dd" aria-label="jenis" required>
                                    <option value="pekerjaan">Lowongan Pekerjaan</option>
                                    <option value="perguruan tinggi">Brosur Kuliah</option>
                                    <option value="lainnya">Lain-lain....</option>
                                </select>
                                @error('jenis')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label for="poster" class="details">Lampiran Poster</label>
                                <input type="file" name="poster" id="poster" accept="image/*"><br>
                                @error('poster')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="user-details">
                            <div class="input-box">
                                <label for="description" class="details">Deskripsi</label>
                                <textarea name="description" id="" cols="30" rows="10" placeholder="Deskripsikan Postingan kamu..."></textarea><br>
                            </div>
                        </div>
                        <div class="contain-btn">
                            <a href="{{ route('events.admin.dashboard') }}" role="button" class="back-btn">kembali</a>
                            <button type="submit" class="send-btn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const errorMessages = document.querySelectorAll(".error-message");
            errorMessages.forEach(function (errorMessages){
                errorMessages.style.display = "flex";
            });
        });
    </script>
</html>