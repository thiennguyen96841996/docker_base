@php
    $bookmarks = request()->session()->get('bookmark', [])
@endphp

<nav class="navbar navbar-expand-lg navbar-white bg-white">
    <button type="button" id="sidebarCollapse" class="btn ms-2">
        <i class="fas fa-bars"></i><span></span>
    </button>

    <div class="collapse navbar-collapse mx-3" id="navbarSupportedContent">
        <ul class="nav navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <div class="nav-dropdown">
                    <a href="#" id="nav1" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-link"></i> <span>Truy cập nhanh</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav1">
                        <div class="dropdown-content">
                            <ul class="nav-list">
                                @if (count($bookmarks) > 0)
                                    @foreach (array_reverse($bookmarks) as $bookmark)
                                        <li><a href="{{ $bookmark['link'] }}" class="dropdown-item"><i class="fas fa-link"></i> {{ $bookmark['name'] }}</a></li>
                                    @endforeach
                                @else
                                    <li class="dropdown-item">Chưa có link nào</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <div class="nav-dropdown">
                    <form method="GET" action="{{ route('admin.logout.logout') }}">
                        @csrf
                        <button type="submit" class="btn nav-item nav-link text-secondary"><i style="font-size: 1.2rem;" class="fas fa-sign-out-alt"></i> Đăng xuất</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
