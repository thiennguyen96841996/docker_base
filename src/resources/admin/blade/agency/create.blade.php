@extends('main')

@section('CONTENTS')
    <h3>Agency create</h3>
    <form method="POST" action="{{ route('admin.agency.store') }}">
        @csrf
        <label>Name:</label><input type="text" name="name">
        <label>Tel:</label><input type="text" name="tel">
        <label>Address:</label><input type="text" name="address">
        <input type="submit" value="submit">
    </form>
@stop
