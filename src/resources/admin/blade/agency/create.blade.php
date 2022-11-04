@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('CONTENTS')
    @include('include.msg.error-msg')
    <h3>Agency create</h3>
    <form method="POST" action="{{ route('admin.agency.createConfirm') }}">
        @csrf
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldOrElse('name', $agency) }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldOrElse('tel', $agency) }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldOrElse('address', $agency) }}">
        <input type="submit" value="submit">
    </form>
@stop
