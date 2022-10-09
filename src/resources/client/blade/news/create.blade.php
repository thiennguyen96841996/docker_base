@extends('main')

@php $news = Renderer::get('news') @endphp

@section('CONTENTS')
  @include('include.error-msg')
  
  <h3>News create</h3>
  <form method="POST" action="{{ route('client.news.createConfirm') }}" enctype="multipart/form-data">
    @csrf
    
    <input type="file" name="file">
    <label>Title:</label><input type="text" name="title" value="{{ Renderer::oldOrElse('title', $news) }}">
    <label>Status:</label><input type="text" name="status" value="{{ Renderer::oldOrElse('status', $news) }}">
    <label>Content:</label><input type="text" name="content" value="{{ Renderer::oldOrElse('content', $news) }}">
    <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">
    <input type="submit" value="submit">
  </form>
@endsection