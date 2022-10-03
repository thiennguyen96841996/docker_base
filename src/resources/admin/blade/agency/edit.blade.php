@extends('main')

@section('CONTENTS')
    @include('include.error-msg')
    <h3>Agency edit</h3>
    <form method="post" action="{{ route('admin.agency.updateConfirm') }}">
        @csrf
        @if (!empty($agency = Renderer::get('agency')))
                <label>ID</label>{{ $agency['id'] }}
        @endif
        <input type="hidden" name="id" value="{{ $agency['id'] }}">
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldOrElse('name', $agency) }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldOrElse('tel', $agency) }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldOrElse('address', $agency) }}">
        <input type="submit" value="submit">
    </form>
@stop
