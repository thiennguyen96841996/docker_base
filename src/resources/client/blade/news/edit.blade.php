@extends('main')

@php $news = Renderer::get('news') @endphp

@section('CONTENTS')
  @include('include.error-msg')

  <h3>News edit</h3>
  <form method="POST" action="{{ route('client.news.updateConfirm', $news->id) }}">
    @csrf
    
    @if (!empty($news))
      <label>ID</label>{{ $news->id }}
    @endif
    <input type="hidden" name="id" value="{{ $news->id }}">
    <label>Title:</label><input type="text" name="title" value="{{ Renderer::oldOrElse('title', $news) }}">
    <label>Status:</label><input type="text" name="status" value="{{ Renderer::oldOrElse('status', $news) }}">
    <label>Content:</label><input type="text" name="content" value="{{ Renderer::oldOrElse('content', $news) }}">
    <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">
    <input type="submit" value="submit">
  </form>
@endsection