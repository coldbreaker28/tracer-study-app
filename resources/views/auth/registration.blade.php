@extends('layout')
  
@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nama Anda</label>
                            <div class="col-md-6">
                                <input type="text" id="name" class="form-control" name="name" placeholder="Nama anda" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div><br>

                        <div class="form-group row">
                            <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" id="email_address" class="form-control" name="email" placeholder="Email anda" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div><br>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="Password anda" required>
                                    <span class="input-group-text" id="seePassword"><i class="toggle-password fas fa-eye" onclick="togglePassword()"></i></span>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div><br>

                        <div class="form-group row">
                            <label for="level" class="col-md-4 col-form-label text-md-right">Status</label>
                            <div class="col-md-6">
                                <select aria-placeholder="dd" aria-label="level" name="level" id="level" class="form-select">
                                    <option value="siswa">Alumni</option>
                                    <!-- <option value="guru">Guru</option> -->
                                </select>
                                @if ($errors->has('level'))
                                    <span class="text-danger">{{ $errors->first('level') }}</span>
                                @endif
                            </div>
                        </div><br>

                        <!-- Untuk Siswa -->
                        <div id="siswaFields" style="display: block;">
                            <div class="form-group row">
                                <label for="tanggal_lahir" class="col-md-4 col-form-label text-md-right">Tanggal Lahir</label>
                                <div class="col-md-6">
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control">
                                    @if ($errors->has('tanggal_lahir'))
                                        <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                                    @endif
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="alamat" class="col-md-4 col-form-label text-md-right">Alamat</label>
                                <div class="col-md-6">
                                    <input type="text" id="alamat" class="form-control" name="alamat" placeholder="Alamat anda">
                                    @if ($errors->has('alamat'))
                                        <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                    @endif
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="nama_orang_tua" class="col-md-4 col-form-label text-md-right">Nama Orang Tua</label>
                                <div class="col-md-6">
                                    <input type="text" id="nama_orang_tua" class="form-control" name="nama_orang_tua" placeholder="Nama orang tua anda">
                                    @if ($errors->has('nama_orang_tua'))
                                        <span class="text-danger">{{ $errors->first('nama_orang_tua') }}</span>
                                    @endif
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="nis" class="col-md-4 col-form-label text-md-right">NIS / Nomor Induk Sekolah</label>
                                <div class="col-md-6">
                                    <input type="text" id="nis" class="form-control" name="nis" placeholder="Nomor induk sekolah anda">
                                    @if ($errors->has('nis'))
                                        <span class="text-danger">{{ $errors->first('nis') }}</span>
                                    @endif
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="nisn" class="col-md-4 col-form-label text-md-right">NISN / Nomor Induk Sekolah Nasional</label>
                                <div class="col-md-6">
                                    <input type="text" id="nisn" class="form-control" name="nisn" placeholder="Nomor induk sekolah nasional anda">
                                    @if ($errors->has('nisn'))
                                        <span class="text-danger">{{ $errors->first('nisn') }}</span>
                                    @endif
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="status_siswa" class="col-md-4 col-form-label text-md-right">Status Siswa</label>
                                <div class="col-md-6">
                                    <select aria-label="status_siswa" name="status_siswa" id="status_siswa" class="form-select">
                                        <option value="Lulus">Lulus</option>
                                    </select>
                                    @if ($errors->has('status_siswa'))
                                        <span class="text-danger">{{ $errors->first('status_siswa') }}</span>
                                    @endif
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="tanggal_lulus" class="col-md-4 col-form-label text-md-right">Tanggal Lulus</label>
                                <div class="col-md-6">
                                    <input type="date" id="tanggal_lulus" class="form-control" name="tanggal_lulus">
                                    @if ($errors->has('tanggal_lulus'))
                                        <span class="text-danger">{{ $errors->first('tanggal_lulus') }}</span>
                                    @endif
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="kompetensi_keahlian" class="col-md-4 col-form-label text-md-right">Kompetensi Keahlian</label>
                                <div class="col-md-6">
                                    <select aria-label="kompetensi_keahlian" name="kompetensi_keahlian" id="kompetensi_keahlian" class="form-select">
                                        @foreach($jurusan as $jurusans)
                                            <option value="{{ $jurusans->id }}">{{ $jurusans->kompetensi_keahlian }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('kompetensi_keahlian'))
                                        <span class="text-danger">{{ $errors->first('kompetensi_keahlian') }}</span>
                                    @endif
                                </div>
                            </div><br>
                        </div>

                        <!-- Untuk Guru -->
                        <div id="guruFields" style="display: none;">
                            <div class="form-group row">
                                <label for="jabatan" class="col-md-4 col-form-label text-md-right">Jabatan</label>
                                <div class="col-md-6">
                                    <input type="text" id="jabatan" class="form-control" name="jabatan" placeholder="Jabatan anda">
                                    @if ($errors->has('jabatan'))
                                        <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                                    @endif
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label for="alamat_guru" class="col-md-4 col-form-label text-md-right">Alamat</label>
                                <div class="col-md-6">
                                    <input type="text" id="alamat_guru" class="form-control" name="alamat_guru" placeholder="Alamat anda">
                                    @if ($errors->has('alamat_guru'))
                                        <span class="text-danger">{{ $errors->first('alamat_guru') }}</span>
                                    @endif
                                </div>
                            </div><br>
                        </div>

                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right">Avatar</label>
                            <div class="col-md-6">
                                <input type="file" id="avatar" class="form-control" name="avatar" required>
                                @if ($errors->has('avatar'))
                                    <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                @endif
                            </div>
                        </div><br>

                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var roleSelect = document.getElementById('level');
            var siswaFields = document.getElementById('siswaFields');
            var guruFields = document.getElementById('guruFields');

            roleSelect.addEventListener('change', function () {
                if (roleSelect.value === 'siswa') {
                    siswaFields.style.display = 'block';
                    guruFields.style.display = 'none';
                } else if (roleSelect.value === 'guru') {
                    guruFields.style.display = 'block';
                    siswaFields.style.display = 'none';
                } else {
                    siswaFields.style.display = 'block';
                    guruFields.style.display = 'none';
                }
            });
        });
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var eyeIcon = document.querySelector(".toggle-password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</main>
@endsection