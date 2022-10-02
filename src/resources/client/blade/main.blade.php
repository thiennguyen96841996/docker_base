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
        <title>{{ config('app.name') }}</title>
    @show

    {{-- CSS --}}
    @section ('CSS')
    @show
</head>
<body>
{{-- Contents --}}
@yield ('CONTENTS')

{{-- Javascript --}}
<script type="application/javascript" src="{{ busting('/dist/js/vendor.bundle.js', 'client') }}"></script>
<script type="application/javascript" src="{{ busting('/dist/js/app.bundle.js', 'client') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
@section ('JAVASCRIPT')
@show
</body>
</html>

