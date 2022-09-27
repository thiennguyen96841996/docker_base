@extends('main')

@section('CONTENTS')
    <h3>Agency create</h3>
    <form method="post" action="{{ route('admin.agency.update', $agency->id) }}">
        @csrf
        @method('PUT')
        <label>Name:</label><input type="text" name="name" value="{{ $agency->name }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ $agency->tel }}">
        <label>Address:</label><input type="text" name="address" value="{{ $agency->address }}">
        <input type="submit" value="submit">
    </form>
@stop
