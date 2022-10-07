@extends('main')

@php 
    $clientUser = Renderer::get('clientUser');
@endphp

@section('CONTENTS')
    @include('include.status-msg')
    <h3>Client show</h3>
    <p>Id: {{ $clientUser->id }}</p>
    <p>Name: {{ $clientUser->getName() }}</p>
    <p>Tel: {{ $clientUser->getTel() }}</p>
    <p>Email: {{ $clientUser->email }}</p>
    <p>Status: {{ \App\Common\Database\Definition\AvailableStatus::getName($clientUser->is_available) }}</p>
    <p>Agency: {{ $clientUser->agency_name }}</p>
    <a href="{{ route('admin.clientUser.edit', $clientUser->id) }}">Edit</a>
@stop
