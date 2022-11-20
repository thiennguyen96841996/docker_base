@php
    $isBookmarked = false;
    if (str_contains(json_encode(request()->session()->get('bookmark')), json_encode(url()->full()))) {
        $isBookmarked = true;
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Meta --}}
    @section ('META')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    @show

    {{-- Title --}}
    @section ('TITLE')
        <title>{{ config('app.name') }} | @yield('title') </title>
    @show

    {{-- CSS --}}
    @yield ('CSS')
    <script type="application/javascript" src="{{ busting('/dist/js/vendor.bundle.js', 'admin') }}"></script>
    <script type="application/javascript" src="{{ busting('/dist/js/app.bundle.js', 'admin') }}"></script>
</head>
<body>
    @if (!auth()->user())
        
        {{-- Login Page Content --}}
        @yield ('LOGIN-PAGE-CONTENTS')
    @else
        <div class="wrapper">
            <!-- sidebar section -->
            @include('include.layout.sidebar')
            <!-- end of sidebar section -->
            <div id="content">
                <!-- navbar navigation component -->
                @include('include.layout.navbar')
                <!-- end of navbar navigation -->
                <div class="content py-4">
                    <div class="container">
                        @yield ('MSG')

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="page-title d-flex align-items-center justify-content-start">
                                <h2>
                                    @yield ('page-heading')
                                </h2>
                                @if (!str_contains(Route::current()->getName(), 'bookmark') && (str_contains(Route::current()->getName(), 'index') || str_contains(Route::current()->getName(), 'show')))
                                    @if ($isBookmarked)
                                        <div class="bookmark-text mx-3"><i class="fas fa-bookmark"></i></div>
                                    @else
                                        <a id="bookmark-create-btn" class="text-link mx-3" href="{{ route('admin.bookmark.store') }}">
                                            <i class="fas fa-bookmark"></i>
                                        </a>
                                    @endif
                                @endif
                            </div>
                            
                            @yield ('HEADING-RIGHTBLOCK')
                        </div>

                        @yield ('CONTENTS')
                    </div>
                </div>
            </div>
        </div>

        @include('bookmark.modal.create')
    @endif

    <footer>
        <p class="text-center mt-3">Copyright &copy; 2022 GLC GROUP All rights reserved.</p>
    </footer>

    {{-- Javascript --}}
    <script type="application/javascript" src="{{ busting('/vendor/jquery/jquery.min.js', 'admin') }}"></script>
    <script type="application/javascript" src="{{ busting('/js/main.js', 'admin') }}"></script>
    <script type="application/javascript" src="{{ busting('/js/bookmark.js', 'admin') }}"></script>
    @yield ('JAVASCRIPT')
</body>
</html>
