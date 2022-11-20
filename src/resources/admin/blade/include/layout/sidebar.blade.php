<nav id="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('img/logo.png', 'admin') }}" alt="bootraper logo" class="app-logo">
    </div>
    <ul class="list-unstyled components text-secondary">
        <!-- <li>
            <a href="#authmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-user-shield"></i> TOGGLE SAMPLE</a>
            <ul class="collapse list-unstyled" id="authmenu">
                <li>
                    <a href="#"><i class="fas fa-lock"></i> SAMPLE 1</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-user-plus"></i> SAMPLE 2</a>
                </li>
            </ul>
        </li> -->
        <li>
            <a href="/agency" class="{{ str_contains(Route::current()->getName(), '.agency') ? 'active' : '' }}"><i class="fas fa-briefcase"></i> ĐẠI LÝ</a>
        </li>
        <li>
            <a href="/client-user" class="{{ str_contains(Route::current()->getName(), '.client-user') ? 'active' : '' }}"><i class="fas fa-user-tie"></i> NHÂN VIÊN</a>
        </li>
        <li>
            <a href="/customer-user" class="{{ str_contains(Route::current()->getName(), '.customer-user') ? 'active' : '' }}"><i class="fas fa-user"></i> KHÁCH HÀNG</a>
        </li>
        <li>
            <a href="/post" class="{{ str_contains(Route::current()->getName(), '.post') ? 'active' : '' }}"><i class="fas fa-building"></i> BÀI ĐĂNG</a>
        </li>
        <li>
            <a href="/bookmark" class="{{ str_contains(Route::current()->getName(), '.bookmark') ? 'active' : '' }}"><i class="fas fa-bookmark"></i> Bookmark</a>
        </li>
    </ul>
</nav>
