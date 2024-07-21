<main>
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
    <nav class="nav-bar">
        <button class="toggle-btn" onclick="toggleSidebar()" title="Sidebar Menu"><i class="bi bi-list"></i></button>
        <div class="nav-text">
            <div class="logo-container">
                <img src="{{ asset('images/70286974LOGOSMKN2SPG-600x527.PNG') }}" alt="logo">
            </div>
            <h1 class="logo">Si <span class="var1">Alumni</span></h1>
        </div>
        <div class="nav-text" role="button">
            <div class="user-logout-container">
                <span> <a href="{{ route('update.profile', $user->slug) }}" class="username">{{ Auth::user()->name }}</a> </span>
                <a href="{{ route('logout') }}" class="logo">Log<span class="var1">out</span></a>
            </div>
        </div>
    </nav>
</main>