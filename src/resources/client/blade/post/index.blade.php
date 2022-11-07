@extends('main')

@section('CONTENTS')
    @include('include.status-msg')

    <h3>Post</h3>
    <form method="GET" action="{{ route('client.post.index') }}">
        <label>Id:</label><input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}">
        <label>Title:</label><input type="text" name="title" value="{{ Renderer::oldWithRequest('title') }}">
        <label>Content:</label><input type="text" name="content" value="{{ Renderer::oldWithRequest('content') }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}">
        <input type="submit" value="search">
    </form>
    <a href="{{ route('client.post.create') }}">Create</a>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Status</th>
            <th>Avatar</th>
            <th>Content</th>
            <th>City</th>
            <th>District</th>
            <th>Address</th>
            <th>Price</th>
            <th>Area</th>
            <th>View count</th>
            <th>Closed at</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse(Renderer::getPaginator() ?? [] as $val)
            <tr>
                <td><a href="{{ route('client.post.show', $val->id) }}">{{ $val->id }}</a></td>
                <td>{{ $val->title }}</td>
                <td>{{ $val->status }}</td>
                <td>{{ $val->avatar }}</td>
                <td>{{ $val->content }}</td>
                <td>{{ $val->city }}</td>
                <td>{{ $val->district }}</td>
                <td>{{ $val->address }}</td>
                <td>{{ $val->price }}</td>
                <td>{{ $val->area }}</td>
                <td>{{ $val->view_counts ?? 0 }}</td>
                <td>{{ $val->closed_at }}</td>
                <td><a href="{{ route('client.post.edit', $val->id) }}">Edit</a></td>
                <td>
                    <form method="POST" name="delete_form" action="{{ route('client.post.destroy', $val->id) }}" onClick="delete_post('{{ $val->id }}', '{{ $val->title }}'); return false;">
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

@section ('JAVASCRIPT')
    <script>
        /**
         * post delete
         * @param {String} post_id
         * @param {String} post_title
         */
        function delete_post(post_id, post_title) {
            // 確認ダイアログ用テキスト
            var confirm_txt = '';
            confirm_txt  = '以下のPostを削除します。よろしいですか?\n\n';
            confirm_txt += post_id + ' : ' + post_title;
            // 論理削除処理
            if(confirm(confirm_txt)) {
                document.delete_form.submit();
            }
        }
    </script>
@stop
