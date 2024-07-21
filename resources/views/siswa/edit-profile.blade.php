<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hai {{ $user->name }}</title>
        <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('css/siswa-home.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card-name.css') }}">
        <link rel="stylesheet" href="{{ asset('css/notifikasi.css') }}">
        <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- <script rel="stylesheet" href="{{ asset('js/notifications.js') }}"></script> -->
    </head>
    <div>
        <!-- When there is no desire, all things are at peace. - Laozi -->
        <header>
            <h2 class="logo">Selamat datang</h2>
            <nav class="navigation">
                <a href="{{ route('siswa.index', [$user->slug]) }}">Home</a>
                <a href="{{ route('siswa.index', [$user->slug]) }}" >Karir</a>
                <a href="{{ route('siswa.event', [$user->slug]) }}" >Service</a>
                <br>
                @auth
                    <span class="username">{{ Auth::user()->name }}</span>
                    <div class="notifikasi">
                        <i class="fa-regular fa-envelope" id="notificationIcon"></i>
                        <span class="dot" data-count="0"></span>
                        <div class="pesan-dropdown" id="notificationDropdown">
                            <ul id="notificationList"></ul>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}">Logout</a>
                    <div id="toast-container"></div>
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
        <style>
            .wrapper{
                display: flex;
                justify-content: center;
                align-items: center;
                padding-top: 12%;
            }
            .user-card{
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background-color: #fff;
                border-radius: 10px;
                padding: 40px;
                width: 650px;
                position: relative;
                overflow: hidden;
                box-shadow: 0 2px 20px -5px rgba(0,0,0,0.5);
            }
            .user-card:before {
                content: '';
                position: absolute;
                height: 300%;
                width: 173px;
                background: #262626;
                top: -60px;
                left: -125px;
                z-index: 0;
                transform: rotate(17deg);
            }
            .user-card-img {
                display: flex;
                justify-content: center;
                align-items: center;   
                z-index: 3;
            }
            .user-card-img img{
                width: 150px;
                height: 200px;
                object-fit: cover;
            }
            .user-card-info{
                text-align: center;
                /* padding: 20px; */
            }
            .user-card-info h2{
                font-size: 24px;
                margin: 0;
                margin-bottom: 10px;
                /* font-family: 'Bebas Neue', sans-serif; */
            }
            .user-card-info p {
                font-size: 14px;
                margin-bottom: 2px;
            }
            .user-card-info p span {
                font-weight: 700;
                margin-right: 10px;
            }
            .user-card-info input, .user-card-info span {
                /* width: 100%; */
                padding: 5px;
                margin-bottom: 5px;
                /* border: 1px solid #ddd; */
                /* border-radius: 5px; */
            }
            .user-card-info input:focus {
                border-color: #1E90FF;
            }
            .edit-button {
                display: inline-block;
                margin-top: 5px;
                margin-right: 5px;
                padding: 5px 10px;
                background-color: #1E90FF;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .edit-button:disabled {
                background-color: #cccccc;
            }

            .edit-button.edit-mode {
                background-color: #FF6347;
            }

            .hidden {
                display: none;
            }
            @media only screen and (min-width: 768px) {
                .user-card {
                    flex-direction: row;
                    align-items: flex-start;
                }   
                .user-card-img {
                    margin-right: 20px;
                    margin-bottom: 0;
                }
                
                .user-card-info {
                    text-align: left;
                }
            }

            @media (max-width: 767px){
                .wrapper{
                    padding-top: 3%;
                }
                .user-card:before {
                    width: 300%;
                    height: 200px;
                    transform: rotate(0);
                }
                .user-card-info h2 {
                    margin-top: 25px;
                    font-size: 35px;
                }
                .user-card-info p span {
                    display: block;
                    margin-bottom: 15px;
                    font-size: 18px;
                }
            }
            .avatar-edit-button {
                background: none;
                border: none;
                cursor: pointer;
                position: absolute;
                top: 135px;
                /* right: 10px; */
                font-size: 20px;
                color: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10;
                border-radius: 50%;
            }

            .avatar-edit-button:disabled {
                cursor: not-allowed;
                opacity: 0.5;
            }
        </style>
        <section>
            <div class="wrapper">
                <div class="user-card">
                    <div class="user-card-img" id="avatar-container">
                        <img id="avatar-preview" src="{{ asset('event/' . ($user->avatar ?? 'default.jpg')) }}" alt="Avatar user">
                        <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*" disabled>
                        <button id="avatar-edit-button" class="avatar-edit-button" disabled>
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                    </div>
                    <div class="user-card-info">
                        <h2><input type="text" id="name" value="{{ $user->name }}" disabled></h2>
                        <p><span>Email: </span> <input type="email" id="email" value="{{ $user->email }}" disabled></p>
                        <p><span>Tanggal lahir: </span> <input type="date" id="tanggal_lahir" value="{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') }}" disabled></p>
                        <p><span>Alamat: </span> <input type="text" id="alamat" value="{{ $siswa->alamat }}" disabled></p>
                        <p><span>NIS: </span> {{$siswa->nis }}</p>
                        <p><span>NISN: </span> {{ $siswa->nisn }}</p>
                        <p><span>Nama Orang Tua / Wali : </span> <input type="text" id="nama_orang_tua" value="{{ $siswa->nama_orang_tua }}" disabled></p>
                        <p><span>Tanggal lulus: </span> <input type="date" id="tanggal_lulus" value="{{ \Carbon\Carbon::parse($siswa->tanggal_lulus)->format('Y-m-d') }}" disabled></p>
                    </div>

                    <button class="edit-button" id="editButton" data-slug="{{ $user->slug }}">Edit</button>
                    <button class="edit-button hidden" id="saveButton">Save</button>
                    <button class="edit-button hidden" id="cancelButton">Cancel</button>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#editButton').click(function() {
                        $(this).addClass('hidden');
                        $('#saveButton, #cancelButton').removeClass('hidden');
                        $('.user-card-info input, #avatar, #avatar-edit-button').prop('disabled', false);
                    });

                    $('#cancelButton').click(function() {
                        $(this).addClass('hidden');
                        $('#saveButton').addClass('hidden');
                        $('#editButton').removeClass('hidden');
                        $('.user-card-info input, #avatar, #avatar-edit-button').prop('disabled', true);
                        location.reload();
                    });

                    $('#avatar-edit-button').click(function() {
                        if (!$('#avatar').prop('disabled')) {
                            $('#avatar').click();
                        }
                    });

                    $('#avatar').change(function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                $('#avatar-preview').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                    
                    $('#saveButton').click(function() {
                        var slug = $('#editButton').data('slug');
                        const formData = new FormData();
                        formData.append('name', $('#name').val());
                        formData.append('email', $('#email').val());
                        formData.append('tanggal_lahir', $('#tanggal_lahir').val());
                        formData.append('alamat', $('#alamat').val());
                        formData.append('nama_orang_tua', $('#nama_orang_tua').val());
                        formData.append('tanggal_lulus', $('#tanggal_lulus').val());
                        formData.append('_token', '{{ csrf_token() }}');
                        const avatarFile = $('#avatar')[0].files[0];
                        if (avatarFile) {
                            formData.append('avatar', avatarFile);
                        }

                        $.ajax({
                            url: '/profile/update/' + slug,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                alert('Profile updated successfully!');
                                $('#cancelButton').click(); // Reset the form
                            },
                            error: function(xhr, status, error) {
                                alert('An error occurred while updating the profile.');
                            }
                        });
                    });
                });
            </script>
        </section>
    </div>
</html>