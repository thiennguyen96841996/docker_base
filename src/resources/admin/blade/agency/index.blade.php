@extends('main')

@section('CONTENTS')
    @include('include.status-msg')

    <h3>Agency</h3>
    <form method="GET" action="{{ route('admin.agency.index') }}">
        <label>Id:</label><input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}">
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldWithRequest('tel') }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}">
        <input type="submit" value="search">
    </form>
    <a href="{{ route('admin.agency.create') }}">Create</a>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Tel</th>
            <th>Address</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse(Renderer::getPaginator() ?? [] as $val)
            <tr>
                <td><a href="{{ route('admin.agency.show', $val->id) }}">{{ $val->id }}</a></td>
                <td>{{ $val->name }}</td>
                <td>{{ $val->tel }}</td>
                <td>{{ $val->address }}</td>
                <td><a href="{{ route('admin.agency.edit', $val->id) }}">Edit</a></td>
                <td>
                    <form method="POST" action="{{ route('admin.agency.destroy', $val->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>データがありません</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {!! Renderer::renderPaginator('include.pager') !!}
@stop
