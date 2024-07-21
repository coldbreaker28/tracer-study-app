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
        <nav class="nav-bar">
            <button class="toggle-btn" onclick="toggleSidebar()" title="Sidebar Menu"><i class="bi bi-list"></i></button>
            <div class="nav-text">
                <div class="logo-container">
                    <img src="{{ asset('images/logo smk 2 svg.svg') }}" alt="logo">
                </div>
                <h1 class="logo">Si <span class="var1">Alumni</span></h1>
            </div>
            <div class="nav-text" role="button">
                <div class="user-logout-container">
                    <span>{{ Auth::user()->name }} </span>
                    <span class="avatar">
                        <img src="{{ asset('event/' . Auth::user()->avatar) }}" alt="avatar">
                    </span>
                    <a href="{{ route('logout') }}" class="logo">Log<span class="var1">out</span></a>
                </div>
            </div>
        </nav>
    @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="form-container">
                <div class="form-content">
                    <form action="{{ route('events.update', $data->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <h2 style="text-align: start;">Unggah Poster</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label for="judul" class="details">Judul Poster</label>
                                <input type="text" name="judul" id="judul" value="{{ $data->judul }}" required><br>
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
                        </div>
                        <div class="user-details">
                            <div class="input-box">
                                <label for="description" class="details">Deskripsi</label>
                                <input type="text" name="description" id="description" value="{{ $data->description }}""></input><br>
                                @error('description')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
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