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
        <title>@yield('title')</title>
    @show

    <link href="{{ busting('/css/error.css', 'admin') }}" rel="stylesheet">
    <script type="application/javascript" src="{{ busting('/dist/js/vendor.bundle.js', 'admin') }}"></script>
    <script type="application/javascript" src="{{ busting('/dist/js/app.bundle.js', 'admin') }}"></script>
</head>
<body>

    <div class="wrapper">
        <div class="page vertical-align text-center">
            <div class="page-content vertical-align-middle">
                @yield ('CONTENTS')
                <footer class="page-copyright">
                    <p>Copyright &copy; 2022 GLC GROUP All rights reserved.</p>
                </footer>
            </div>
        </div>
    </div>

{{-- Javascript --}}
<script type="application/javascript" src="{{ busting('/vendor/jquery/jquery.min.js', 'admin') }}"></script>
@section ('JAVASCRIPT')
@show
</body>
</html>
