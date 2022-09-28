@extends('main')

@section('CONTENTS')
    <h3>Agency create</h3>
    <form method="post" action="{{ route('admin.agency.update', $agency->id) }}">
        @csrf
        @method('PUT')
        @if (!empty($agency = Renderer::get('agency')))
                <label>ID</label>{{ $agency->id }}
        @endif
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldOrElse('name', $agency) }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldOrElse('tel', $agency) }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldOrElse('address', $agency) }}">
        <input type="submit" value="submit">
    </form>
@stop
