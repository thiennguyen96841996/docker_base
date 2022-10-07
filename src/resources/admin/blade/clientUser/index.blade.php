@extends('main')

@section('CONTENTS')
    @include('include.status-msg')

    <h3>Client list</h3>
    <form method="GET" action="{{ route('admin.clientUser.index') }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldWithRequest('tel') }}">
        <label>Email:</label><input type="text" name="email" value="{{ Renderer::oldWithRequest('email') }}">
        <label>Status:</label>
        <select name="is_available">
            <option value="">--</option>
            @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                @if (Renderer::oldWithRequest('is_available') == $status->value)
                    <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @else
                    <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                @endif
            @endforeach
        </select>
        <input type="submit" value="search">
    </form>
    <a href="{{ route('admin.clientUser.create') }}">Create</a>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Tel</th>
            <th>Email</th>
            <th>Status</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse(Renderer::getPaginator() ?? [] as $val)
            <tr>
                <td><a href="{{ route('admin.clientUser.show', $val->id) }}">{{ $val->id }}</a></td>
                <td>{{ $val->getName() }}</td>
                <td>{{ $val->getTel() }}</td>
                <td>{{ $val->email }}</td>
                <td>{{ \App\Common\Database\Definition\AvailableStatus::getName($val->is_available) }}</td>
                <td><a href="{{ route('admin.clientUser.edit', $val->id) }}">Edit</a></td>
                <td>
                    <form method="POST" action="{{ route('admin.clientUser.destroy', $val->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" onclick="return confirm('Do you want to delete this client user?');">
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
