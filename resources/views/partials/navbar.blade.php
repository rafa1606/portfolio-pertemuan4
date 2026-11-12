<header class="site-header">
    <div class="nav-shell">
        <a class="brand" href="{{ route('home') }}"><span class="brand-mark">R.</span> Rafa Portfolio</a>
        <nav class="nav-links" aria-label="Navigasi utama">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            <a class="nav-link {{ request()->routeIs('projects', 'projects.show') ? 'active' : '' }}" href="{{ route('projects') }}">Projects</a>
            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
            <a class="nav-link {{ request()->routeIs('education') ? 'active' : '' }}" href="{{ route('education') }}">Education</a>
            <a class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}">Posts</a>

            @auth
            @if (Auth::user()->role === 'admin')
            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard.index') }}">Dashboard</a>
            @endif
            <a class="nav-link {{ request()->routeIs('profile.saya') ? 'active' : '' }}" href="{{ route('profile.saya') }}">Profil</a>
            <span class="nav-link">Halo, {{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-link" style="background:none;border:0;cursor:pointer;font-family:inherit;">Logout</button>
            </form>
            @endauth

            @guest
            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
            @endguest
        </nav>
    </div>
</header>