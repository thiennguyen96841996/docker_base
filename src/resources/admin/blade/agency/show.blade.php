@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('CONTENTS')
    @include('include.msg.status-msg')
    <h3>Agency show</h3>
    <label>Name:</label><p>{{ $agency->name }}</p>
    <label>Tel:</label><p>{{ $agency->tel }}</p>
    <label>Address:</label><p>{{ $agency->address }}</p>
    <a href="{{ route('admin.agency.edit', ['agency' => $agency->id]) }}">edit</a>
@stop
