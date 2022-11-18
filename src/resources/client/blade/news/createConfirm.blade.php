@extends('main')

@section('CONTENTS')
  @include('include.status-msg')

  <h3>News create confirm</h3>
  <label>Title:</label><p>{{ request()->input('title') }}</p>
  <label>Content:</label><p>{{ request()->input('content') }}</p>
  <label>Status:</label><p>{{ request()->input('status') }}</p>
  <label>Avatar:</label><p>{{ request()->input('avatar') }}</p>

  <form method="POST" id="input_form" action="{{ route('client.news.store') }}">
    @csrf
    
    <input type="hidden" name="client_id" value="{{ request()->input('client_id') }}">
    <input type="hidden" name="title" value="{{ request()->input('title') }}">
    <input type="hidden" name="content" value="{{ request()->input('content') }}">
    <input type="hidden" name="status" value="{{ request()->input('status') }}">
    <input type="hidden" name="avatar" value="{{ request()->input('avatar') }}">
    <div >
        <a href="{{ route('client.news.create') }}" class="btn btn-outline-secondary">back</a>
        <input type="submit" value="store">
    </div>
  </form>
@endsection
