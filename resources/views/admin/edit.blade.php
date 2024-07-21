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
        <title>Update Data Siswa</title>
    </head>
    <body class="main-content">
    @include('components.navAdmin')
    @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div class="form-container">
                <!-- <div class="title">Update Data Siswa</div> -->
                <div class="form-content">
                    <form action="{{ route('admin.edit.post', [$alumni->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                        <h2 style="text-align: start;">Alumni</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label class="details" for="name">Nama Lengkap</label>
                                <input name="name" type="text" value="{{ $alumni->name }}" required>
                                @error('name')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="tanggal_lahir">Tanggal Lahir</label>
                                <input class="input-date" type="date" name="tanggal_lahir" value="{{ $alumni->tanggal_lahir }}" required>
                                @error('tanggal_lahir')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="alamat">Alamat</label>
                                <input type="text" value="{{ $alumni->alamat }}" name="alamat" required>
                                @error('alamat')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="nama_orang_tua">Orang Tua / Wali</label>
                                <input type="text" value="{{ $alumni->nama_orang_tua }}" name="nama_orang_tua" required>
                                @error('nama_orang_tua')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="nis">NIS</label>
                                <input type="text" value="{{ $alumni->nis }}" name="nis" required>
                                @error('nis')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="nisn">NISN</label>
                                <input type="text" value="{{ $alumni->nisn }}" name="nisn" required>
                                @error('nisn')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label class="details" for="tanggal_lulus">Tanggal Lulus</label>
                                <input type="date" class="input-date" name="tanggal_lulus" value="{{ $alumni->tanggal_lulus }}" required>
                                @error('tanggal_lulus')
                                    <span class="error-message visible">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <h2 style="text-align: start;">Jurusan</h2><hr>
                        <div class="user-details">
                            <div class="input-box">
                                <label class="details" for="kompetensi_keahlian">Kompetensi Keahlian</label>
                                <select name="kompetensi_keahlian" id="kompetensi_keahlian" aria-placeholder="dd" aria-label="kompetensi_keahlian" required>
                                    <option value="Teknik Kendaraan Ringan Otomotif">Teknik Kendaraan Ringan Otomotif</option>
                                    <option value="Multimedia">Multimedia</option>
                                    <option value="Agrobisnis Pengolahan Hasil Pertanian">Agrobisnis Pengolahan Hasil Pertanian</option>
                                    <option value="Teknik Pemesinan">Teknik Pemesinan</option>
                                    <option value="Teknik Pengelasan">Teknik Pengelasan</option>
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