@extends('main')

@php $post = Renderer::get('post') @endphp

@section('CONTENTS')
    @include('include.error-msg')
    <h3>Post create</h3>
    <form method="POST" action="{{ route('client.post.createConfirm') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <label>Title:</label><input type="text" name="title" value="{{ Renderer::oldOrElse('title', $post) }}">
        <label>Status:</label><input type="text" name="status" value="{{ Renderer::oldOrElse('status', $post) }}">
        <label>Content:</label><input type="text" name="content" value="{{ Renderer::oldOrElse('content', $post) }}">
        <label>City:</label><input type="text" name="city" value="{{ Renderer::oldOrElse('city', $post) }}">
        <label>District:</label><input type="text" name="district" value="{{ Renderer::oldOrElse('district', $post) }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldOrElse('address', $post) }}">
        <label>Price:</label><input type="text" name="price" value="{{ Renderer::oldOrElse('price', $post) }}">
        <label>Area:</label><input type="text" name="area" value="{{ Renderer::oldOrElse('area', $post) }}">
        <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">
        <input type="submit" value="submit">
    </form>
@stop
