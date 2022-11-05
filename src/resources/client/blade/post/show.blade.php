@extends('main')

@php $post = Renderer::get('post') @endphp

@section('CONTENTS')
    @include('include.msg.status-msg')
    <h3>Post show</h3>
    <label>Title:</label><p>{{ $post->title }}</p>
    <label>Status:</label><p>{{ $post->status }}</p>
    <label>Content:</label><p>{{ $post->content }}</p>
    <label>City:</label><p>{{ $post->city }}</p>
    <label>District:</label><p>{{ $post->district }}</p>
    <label>Address:</label><p>{{ $post->address }}</p>
    <label>Price:</label><p>{{ $post->price }}</p>
    <label>Area:</label><p>{{ $post->area }}</p>

    <a href="{{ route('client.post.edit', ['post' => $post->id]) }}">Edit</a>
@stop
