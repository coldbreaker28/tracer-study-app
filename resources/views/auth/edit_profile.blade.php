<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Profile {{ $user->name }}</title>
        <link rel="stylesheet" href="{{ asset('css/siswa-home.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card-name.css') }}">
        <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
        <!-- <script rel="stylesheet" href="{{ asset('js/notifications.js') }}"></script> -->
    </head>
    <div>
        <!-- When there is no desire, all things are at peace. - Laozi -->
        <style>
            body,html{
                height: 100%;
            }
            body {
                background: #79C7FF;   
                font-family: 'Montserrat', sans-serif;
            }
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
                /* align-items: center;    */
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
/* 
            button i {
                color: #262626;
            } */
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
            a{
                text-decoration: none;
            }
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
                        <p><span>Level: </span> <strong>{{ $user->level }}</strong></p>
                    </div>
                    <button class="edit-button" id="editButton" data-slug="{{ $user->slug }}">Edit</button>
                    <button class="edit-button hidden" id="saveButton">Save</button>
                    <button class="edit-button hidden" id="cancelButton">Cancel</button>
                    <a href="{{ route('admin.dashboard') }}" class="back-btn" type="button" title="kembali">Kembali</a>
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
                        // Optionally, reload the page to discard changes or use other logic to revert inputs
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
                        const slug = $('#editButton').data('slug');
                        const formData = new FormData();
                        formData.append('name', $('#name').val());
                        formData.append('email', $('#email').val());
                        if ($('#avatar')[0].files[0]) {
                            formData.append('avatar', $('#avatar')[0].files[0]);
                        }
                        formData.append('_token', '{{ csrf_token() }}');

                        $.ajax({
                            url: '{{ url("admin/profile/update/") }}/' + slug,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                alert('Profile updated successfully!');
                                $('#cancelButton').click();
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