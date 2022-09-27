@extends('main')

@section('CONTENTS')
    <h3>Agency show</h3>
    <label>Name:</label><p>{{ $agency->name }}</p>
    <label>Tel:</label><p>{{ $agency->tel }}</p>
    <label>Address:</label><p>{{ $agency->address }}</p>
@stop
