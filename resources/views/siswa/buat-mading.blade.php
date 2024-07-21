<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hai {{ $user->name }}</title>
    <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/siswa-home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
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
    <section id="event">
        <div class="container" id="#Event">
            <div class="content">
                <div class="form-container">
                    <div class="form-content">
                        <form action="{{ route('siswa.store-mading', [$user->slug]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <h2 style="text-align: start;">Unggah Acara</h2><hr>
                            <div class="user-details">
                                <div class="input-box">
                                    <label for="judul" class="details">Judul Acara</label>
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
                                    <label for="poster" class="details">Poster Event</label>
                                    <input type="file" name="poster" id="poster" accept="image/*"><br>
                                    @error('poster')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="user-details">
                                <div class="input-box">
                                    <label for="description" class="details">Deskripsi</label>
                                    <input name="description" id="description" placeholder="Deskripsikan Postingan kamu..."><br>
                                    @error('description')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <style>
                                .back-btn {
                                    background-color: #fc3e48;
                                    color: #fff;
                                    border: none;
                                    padding: 8px 15px;
                                    border-radius: 8px;
                                    font-size: 12px;
                                    cursor: pointer;
                                    box-shadow: 0 5px 10px rgba(148, 0, 255, 0.1);
                                }
                                .back-btn:hover {
                                    background-color: #EB3B5A;
                                }

                                .send-btn{
                                    background-color: #0A7FE6;
                                    color: #FFFFFF;
                                    border: none;
                                    padding: 8px 15px;
                                    border-radius: 8px;
                                    font-size: 12px;
                                    cursor: pointer;
                                    box-shadow: 0 5px 10px rgba(148, 0, 255, 0.1);
                                }
                                .send-btn:hover{
                                    background-color: #0c70c7;
                                }
                            </style>
                            <div class="contain-btn">
                                <a href="{{ route('siswa.event', [$user->slug]) }}" role="button" class="back-btn">kembali</a>
                                <button type="submit" class="send-btn">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>