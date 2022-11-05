@extends ('main')

 {{-- Contents --}}
 @section ('CONTENTS')
    @include('include.msg.status-msg')
    
    <h3>News confirm</h3>
    @if (!empty(request()->input('id')))
        <label>ID</label><p>{{ request()->input('id') }}</p>
    @endif
    <label>Title:</label><p>{{ request()->input('title') }}</p>
    <label>Status:</label><p>{{ request()->input('status') }}</p>
    <label>Content:</label><p>{{ request()->input('content') }}</p>

    <form method="POST" id="input_form" action="{{ route('client.news.update', ['news' => request()->input('id')]) }}">
        @method("PUT")
        @csrf

        <input type="hidden" name="id" value="{{ request()->input('id') }}">
        <input type="hidden" name="title" value="{{ request()->input('title') }}">
        <input type="hidden" name="status" value="{{ request()->input('status') }}">
        <input type="hidden" name="content" value="{{ request()->input('content') }}">
        <input type="hidden" name="client_id" value="{{ request()->input('client_id') }}">
        <div >
            <a href="{{ route('client.news.edit', ['news' => request()->input('id')]) }}" >back</a>
            <input type="submit" value="update">
        </div>
    </form>
 @endsection
