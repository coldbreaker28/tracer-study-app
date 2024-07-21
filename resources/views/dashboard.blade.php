@extends('layout')
  
@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Announcement!!!</div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            Selamat datang, {{ Auth::user()->name }}! Anda berhasil masuk.
                        </div>

                        <!-- Isi dari dashboard atau informasi yang ingin ditampilkan kepada pengguna -->
                        <p>Ini adalah halaman dashboard. Anda dapat melihat informasi penting di sini.</p>
                        <!-- Tambahkan konten dashboard di sini -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection