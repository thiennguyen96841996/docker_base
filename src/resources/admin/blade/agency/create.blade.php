@extends('main')

@section('CONTENTS')
    @include('include.error-msg')
    <h3>Agency create</h3>
    <form method="POST" action="{{ route('admin.agency.store') }}">
        @csrf
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldOrElse('name', '') }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldOrElse('tel', '') }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldOrElse('address', '') }}">
        <input type="submit" value="submit">
    </form>
@stop
