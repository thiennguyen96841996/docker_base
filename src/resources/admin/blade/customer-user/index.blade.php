@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <h3>Client list</h3>
    <form method="GET" action="{{ route('admin.customer-user.index') }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldWithRequest('tel') }}">
        <label>Email:</label><input type="text" name="email" value="{{ Renderer::oldWithRequest('email') }}">
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}">
        <input type="submit" value="search">
    </form>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Tel</th>
            <th>Email</th>
            <th>Address</th>
            <th>Birthday</th>
            <th>Gender</th>
        </tr>
        </thead>
        <tbody>
        @forelse(Renderer::getPaginator() ?? [] as $val)
            <tr>
                <td><a href="{{ route('admin.customer-user.show', $val->id) }}">{{ $val->id }}</a></td>
                <td>{{ $val->getName() }}</td>
                <td>{{ $val->getTel() }}</td>
                <td>{{ $val->email }}</td>
                <td>{{ $val->getAddress() }}</td>
                <td>{{ $val->getBirthday() }}</td>
                <td>{{ $val->getGender() }}</td>
                <td><a href="{{ route('admin.customer-user.edit', $val->id) }}">Edit</a></td>
                <td>
                    <form method="POST" action="{{ route('admin.customer-user.destroy', $val->id) }}">
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
