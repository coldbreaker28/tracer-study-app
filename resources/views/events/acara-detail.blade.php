<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <link rel="stylesheet" href="{{ asset('css/post.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <title>Dashboard Events</title>
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
            <article class="card-detail">
                <img src="{{ asset('event/' . $data->poster) }}" alt="Poster Acara" class="card-detail-image">
                <div class="card-detail-body">
                    <h3 class="card-title">{{ $data->judul }}</h3>
                    <p class="author-name">{{ $data->description }}</p>
                    <div class="card-author">
                        <div class="author-details-detail">
                            <span class="publish-date">{{ $data->updated_at->format('d-F-Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="post-btn-group">
                    <a href="{{ route('events.admin.dashboard') }}" role="button" title="kembali" class="post-btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                    <a href="{{ route('events.admin.edit', $data->id) }}" role="button" title="edit" class="post-btn-edit"><i class="fa-solid fa-pencil"></i> Edit</a>
                </div>
            </article>
        </div>
    </body>
</html>