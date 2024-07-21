<div>
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/form.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->
        <title>Tambah Data Siswa</title>
    </head>
    <body>
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <br>
            <div class="form-container">
                <!-- <div class="title">Registrasi Siswa</div> -->
                <div class="form-content">
                    <form method="POST" action="{{ route('admin.create.post') }}" enctype="multipart/form-data">
                        @csrf
                        <h2 style="text-align: start;">Alumni</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label class="details" for="name">Nama Lengkap</label>
                                <input name="name" type="text" placeholder="nama..." required><br>
                                @error('name')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="email">Email</label>
                                <input name="email" type="email" placeholder="email" required><br>
                                @error('email')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="password">Password</label>
                                <input name="password" type="password" placeholder="{{ str_repeat('*', 8) }}" required><br>
                                @error('password')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="level">Status</label>
                                <select name="level" id="level" aria-placeholder="dd" aria-label="level">
                                    <option value="siswa">siswa</option>
                                </select>
                                @error('level')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="nis">NIS</label>
                                <input type="text" name="nis" placeholder="no. induk siswa..." required>
                                @error('nis')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="nisn">NISN</label>
                                <input type="text" name="nisn" placeholder="no. induk siswa nasional..." required>
                                @error('nisn')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="status_siswa">Status siswa</label>
                                <select name="status_siswa" id="status_siswa" aria-placeholder="dd" aria-label="status_siswa">
                                    <!-- <option value="Belum lulus">Belum lulus</option> -->
                                    <option value="lulus">Lulus</option>
                                </select>
                                @error('status_siswa')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="Avatar">Avatar</label>
                                <input name="avatar" type="file" required id="avatar"><br>
                                @error('password')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="tanggal_lulus">Tanggal Lulus</label>
                                <input type="date" class="input-date" name="tanggal_lulus" required>
                                @error('tanggal_lulus')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <h2 style="text-align: start;">Jurusan</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label class="details" for="kompetensi_keahlian">Jurusan</label>
                                <select name="kompetensi_keahlian" id="kompetensi_keahlian" aria-placeholder="dd" aria-label="kompetensi_keahlian" required>
                                    @foreach($jurusan as $kompetensi)
                                        <option value="{{ $kompetensi->id}}">{{ $kompetensi->kompetensi_keahlian}}</option>
                                    @endforeach
                                </select>
                                @error('kompetensi_keahlian')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="contain-btn">
                            <a href="{{ route('admin.dashboard') }}" role="button" class="back-btn">kembali</a>
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
