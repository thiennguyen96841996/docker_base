@extends('main')

@php $post = Renderer::get('post') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Post {{ $post->id }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <input type="text" class="form-control" value="{{ $post->title }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Content</label>
                <textarea class="form-control" rows="10" readonly>{{ $post->content }}</textarea>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">City</label>
                    <input type="text" value="{{ $post->city }}" class="form-control" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">District</label>
                    <input type="text" value="{{ $post->district }}" class="form-control" readonly>
                </div>
            </div>
            <div class="mb-3">
                    <label class="form-label fw-bold">Address</label>
                    <input type="text" value="{{ $post->address }}" class="form-control" readonly>
                </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Price (VNĐ)</label>
                    <input type="text" value="{{ number_format($post->price) }}" class="form-control" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Area (m2)</label>
                    <input type="number" value="{{ $post->area }}" class="form-control" readonly>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Published At</label>
                    <input type="text" class="form-control" value="{{ $post->published_at }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Closed At</label>
                    <input type="text" class="form-control" value="{{ $post->closed_at }}" readonly>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Client</label>
                    <input type="text" class="form-control" value="{{ $post->client_id }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <input type="text" class="form-control" value="{{ \App\Common\Database\Definition\AvailableStatus::getName($post->status) }}" readonly>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">View count</label>
                    <input type="text" class="form-control" value="{{ $post->view_counts }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.post.index') }}" class="btn btn-outline-secondary">Back to list</a>
        <div class="d-flex justify-content-start text-center">
            <div class="mx-1">
                <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
            </div>
            <div>
                <form method="POST" name="delete_form" action="{{ route('admin.post.destroy', $post->id) }}" onClick="delete_post('{{ $post->id }}', '{{ $post->title }}'); return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                </form>
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