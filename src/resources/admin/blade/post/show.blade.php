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
    <div class="card detail-page">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Avatar</label>
                <div><img src="{{ $post->avatar != null ? \App\Common\AWS\S3Service::display(\App\Common\Post\Definition\PostAvatar::POST_AVATAR_FOLDER, $post->id . '/' . \Carbon\Carbon::now()->format('Y') . '_' . \Carbon\Carbon::now()->format('m') . '/' . \App\Common\Post\Definition\PostAvatar::POST_IMAGE_FOLDER . '/' . $post->avatar) : asset(\App\Common\Post\Definition\PostAvatar::CLIENT_POST_DEFAULT_AVATAR) }}" alt="postAvatar"></div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Title</label>
                <div class="form-control">{{ $post->title }}</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Slug</label>
                <div class="form-control">{{ $post->slug }}</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Content</label>
                <textarea class="form-control" rows="10" readonly>{{ $post->content }}</textarea>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">City</label>
                    <div class="form-control">{{ $post->city_name }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">District</label>
                    <div class="form-control">{{ $post->district_name }}</div>
                </div>
            </div>
            <div class="mb-3">
                    <label class="form-label fw-bold">Address</label>
                    <div class="form-control">{{ $post->address }}</div>
                </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Price (VNĐ)</label>
                    <div class="form-control">{{ number_format($post->price) }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Area (m2)</label>
                    <div class="form-control">{{ $post->area }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Published At</label>
                    <div class="form-control">{{ $post->getPublishedAt() }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Closed At</label>
                    <div class="form-control">{{ $post->getClosedAt() }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Client ID</label>
                    <div class="form-control"><a href="{{ route('admin.client-user.show', $post->client_id) }}" class="text-link">{{ $post->client_id }}</a></div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Client Name</label>
                    <div class="form-control">{{ $post->getClientName() }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Views</label>
                    <div class="form-control">{{ number_format($post->views) }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <div class="form-control">{{ \App\Common\Post\Definition\PostStatus::getName($post->status) }}</div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.post.index') }}" class="btn btn-outline-secondary">Back to list</a>
@stop
