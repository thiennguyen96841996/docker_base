@extends('main')

@php $post = Renderer::get('post') @endphp

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.status-msg')
@stop

@section('page-heading')
    Post {{ $post->id }}
@stop

@section('CONTENTS')
    <div class="card detail-page">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Ảnh đại diện</label>
                <div><img src="{{ $post->avatar != null ? \App\Common\AWS\S3Service::display(\App\Common\Post\Definition\PostAvatar::POST_AVATAR_FOLDER, $post->id . '/' . \Carbon\Carbon::now()->format('Y') . '_' . \Carbon\Carbon::now()->format('m') . '/' . \App\Common\Post\Definition\PostAvatar::POST_IMAGE_FOLDER . '/' . $post->avatar) : asset(\App\Common\Post\Definition\PostAvatar::CLIENT_POST_DEFAULT_AVATAR) }}" alt="postAvatar"></div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tiêu đề</label>
                <div class="form-control">{{ $post->title }}</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Slug</label>
                <div class="form-control">{{ $post->slug }}</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nội dung</label>
                <textarea class="form-control" rows="10" readonly>{{ $post->content }}</textarea>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tình/Thành phố</label>
                    <div class="form-control">{{ $post->city_name }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Quận/Huyện</label>
                    <div class="form-control">{{ $post->district_name }}</div>
                </div>
            </div>
            <div class="mb-3">
                    <label class="form-label fw-bold">Địa chỉ</label>
                    <div class="form-control">{{ $post->address }}</div>
                </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Giá (VNĐ)</label>
                    <div class="form-control">{{ number_format($post->price) }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Diện tích (m2)</label>
                    <div class="form-control">{{ $post->area }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Thời điểm công khai</label>
                    <div class="form-control">{{ $post->getPublishedAt() }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Thời điểm đóng bài dăng</label>
                    <div class="form-control">{{ $post->getClosedAt() }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">ID nhân viên</label>
                    <div class="form-control"><a href="{{ route('admin.client-user.show', $post->client_id) }}" class="text-link">{{ $post->client_id }}</a></div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tên nhân viên</label>
                    <div class="form-control">{{ $post->getClientName() }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Số lượt xem</label>
                    <div class="form-control">{{ number_format($post->views) }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tình trạng</label>
                    <div class="form-control">{{ \App\Common\Post\Definition\PostStatus::getName($post->status) }}</div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.post.index') }}" class="btn btn-outline-secondary">Quay lại</a>
@stop
