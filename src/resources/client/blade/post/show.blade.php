@extends('main')

@php $post = Renderer::get('post') @endphp

@section('CONTENTS')
    @include('include.status-msg')
    <h3>Post show</h3>
    <label>Title:</label><p>{{ $post->title }}</p>
    <label>Status:</label><p>{{ \App\Common\Database\Definition\AvailableStatus::getName($post->status) }}</p>
    <label>Content:</label><p>{{ $post->content }}</p>
    <label>City:</label><p>{{ $post->city }}</p>
    <label>District:</label><p>{{ $post->district }}</p>
    <label>Address:</label><p>{{ $post->address }}</p>
    <label>Price:</label><p>{{ $post->price }}</p>
    <label>Area:</label><p>{{ $post->area }}</p>
    <label>Avatar:</label><p><a target="_blank" href="{{ \App\Common\AWS\S3Service::display(\App\Common\Post\Definition\PostAvatar::POST_AVATAR_FOLDER, $post->id . '/' . \Carbon\Carbon::now()->format('Y') . '_' . \Carbon\Carbon::now()->format('m') . '/' . \App\Common\Post\Definition\PostAvatar::POST_IMAGE_FOLDER . '/' . $post->avatar) }}"><img class="image" style="width: 192px; height: 130px;" src="{{ $post->avatar != null ? \App\Common\AWS\S3Service::display(\App\Common\Post\Definition\PostAvatar::POST_AVATAR_FOLDER, $post->id . '/' . \Carbon\Carbon::now()->format('Y') . '_' . \Carbon\Carbon::now()->format('m') . '/' . \App\Common\Post\Definition\PostAvatar::POST_IMAGE_FOLDER . '/' . $post->avatar) : asset(\App\Common\Post\Definition\PostAvatar::CLIENT_POST_DEFAULT_AVATAR) }}" alt="{{ $post->avatar }}" /></a></p>

    <a href="{{ route('client.post.edit', ['post' => $post->id]) }}">Edit</a>
@stop
