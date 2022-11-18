@extends('main')

 @php $news = Renderer::get('news') @endphp

 @section('CONTENTS')
    @include('include.status-msg')
    <h3>News show</h3>
    <label>Title:</label><p>{{ $news->title }}</p>
    <label>Status:</label><p>{{ $news->status }}</p>
    <label>Content:</label><p>{{ $news->content }}</p>

    <a href="{{ route('client.news.edit', ['news' => $news->id]) }}">Edit</a>
 @stop
