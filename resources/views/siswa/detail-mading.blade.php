<body>
    <link rel="stylesheet" href="{{ asset('css/post.css') }}">
    <link rel="stylesheet" href="{{ asset('css/siswa-home.css') }}">
    <script src="https://kit.fontawesome.com/e10155b56c.js" crossorigin="anonymous"></script>
    <div>
        <!-- Be present above all else. - Naval Ravikant -->
        <section id="event">
            <div class="container" id="#Event">
                <article class="card-detail">
                    <img src="{{ asset('event/' . $mading->poster) }}" alt="Poster Acara" class="card-detail-image">
                    <div class="card-detail-body">
                        <h3 class="card-title">{{ $mading->judul }}</h3>
                        <p class="author-name">{{ $mading->description }}</p>
                        <div class="card-author">
                            <div class="author-details-detail">
                                <span class="publish-date">{{ $mading->updated_at->format('d-F-Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/') }}" role="button" title="kembali" class="post-btn-back"><i class="fa-solid fa-arrow-left"></i></a>
                </article>
            </div>
        </section>
    </div>
</body>
