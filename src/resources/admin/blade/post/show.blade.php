@extends('main')

@php $post = Renderer::get('post') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Post Show
        </h3>
    </div>
    <div class="box">
        <table class="table table-bordered">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Avatar</th>
                    <td>{{ $post->avatar }}</td>
                </tr>
                <tr>
                    <th scope="row">Title</th>
                    <td>{{ $post->title }}</td>
                </tr>
                <tr>
                    <th scope="row">Status</th>
                    <td>{{ $post->status }}</td>
                </tr>
                <tr>
                    <th scope="row">Content</th>
                    <td>{{ $post->content }}</td>
                </tr>
                <tr>
                    <th scope="row">City</th>
                    <td>{{ $post->city }}</td>
                </tr>
                <tr>
                    <th scope="row">District</th>
                    <td>{{ $post->district }}</td>
                </tr>
                <tr>
                    <th scope="row">Address</th>
                    <td>{{ $post->address }}</td>
                </tr>
                <tr>
                    <th scope="row">Price</th>
                    <td>{{ $post->price }}</td>
                </tr>
                <tr>
                    <th scope="row">Area</th>
                    <td>{{ $post->area }}</td>
                </tr>
                <tr>
                    <th scope="row">View count</th>
                    <td>{{ $post->view_counts ?? 0 }}</td>
                </tr>
                <tr>
                    <th scope="row">Client</th>
                    <td>{{ $post->client_id }}</td>
                </tr>
                <tr>
                    <th scope="row">Published at</th>
                    <td>{{ $post->published_at }}</td>
                </tr>
                <tr>
                    <th scope="row">Closed at</th>
                    <td>{{ $post->closed_at }}</td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <div class="m-2">
                <form method="POST" name="delete_form" action="{{ route('admin.post.destroy', $post->id) }}" onClick="delete_post('{{ $post->id }}', '{{ $post->title }}'); return false;" class="d-table-cell">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
            <div class="m-2">
                <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-info">Edit</a>
            </div>
        </div>    
    </div>
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
            confirm_txt  = 'Bạn có chắc chắn muốn xoá thông tin post dưới không?\n\n';
            confirm_txt += post_id + ' : ' + post_title;
            // 論理削除処理
            if(confirm(confirm_txt)) {
                document.delete_form.submit();
            }
        }
    </script>
@stop