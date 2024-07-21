<main>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    <h2 class="logo">Selamat datang</h2>
    <nav class="navigation">
        <a href="{{ route('siswa.index', [$user->slug]) }}" >Home</a>
        <a href="{{ route('siswa.index', [$user->slug]) }}" >Karir</a>
        <a href="#Event" class="active">Event</a>
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
</main>
