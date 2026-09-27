<header class="site-header">
    <div class="nav-shell">
        <a class="brand" href="{{ route('home') }}"><span class="brand-mark">R.</span> Rafa Portfolio</a>
        <nav class="nav-links" aria-label="Navigasi utama">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            <a class="nav-link {{ request()->routeIs('projects') ? 'active' : '' }}" href="{{ route('projects') }}">Projects</a>
            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
            <a class="nav-link {{ request()->routeIs('education') ? 'active' : '' }}" href="{{ route('education') }}">Education</a>
            <a class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}">Posts</a>
        </nav>
    </div>
</header>