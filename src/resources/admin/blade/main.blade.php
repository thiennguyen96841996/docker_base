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
    @section ('CSS')
    @show
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
                    @yield ('CONTENTS')
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Javascript --}}
<script type="application/javascript" src="{{ busting('/vendor/jquery/jquery.min.js', 'admin') }}"></script>
<script type="application/javascript" src="{{ busting('/js/main.js', 'admin') }}"></script>
@section ('JAVASCRIPT')
@show
</body>
<footer>
  <p class="text-center mt-3">Copyright &copy; 2022 GLC GROUP All rights reserved.</p>
</footer>
</html>
