<nav id="sidebar">
    <div class="sidebar-header">
        <img style="max-height: 50px;" src="{{ busting('img/logo.png', 'admin') }}" alt="bootraper logo" class="app-logo">
    </div>
    <ul class="list-unstyled components text-secondary">
        <li>
            <a href="/"><i class="fas fa-home"></i> Dashboard</a>
        </li>
        <li>
            <a href="#authmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-user-shield"></i> TOGGLE SAMPLE</a>
            <ul class="collapse list-unstyled" id="authmenu">
                <li>
                    <a href="#"><i class="fas fa-lock"></i> SAMPLE 1</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-user-plus"></i> SAMPLE 2</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/agency"><i class="fas fa-user-tie"></i> Agencies</a>
        </li>
        <li>
            <a href="/"><i class="fas fa-user-friends"></i> Users</a>
        </li>
    </ul>
</nav>
