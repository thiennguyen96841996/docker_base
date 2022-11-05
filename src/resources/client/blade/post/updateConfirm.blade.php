@extends ('main')

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.msg.status-msg')

    <h3>Post confirm</h3>
    @if (!empty(request()->input('id')))
        <label>ID</label><p>{{ request()->input('id') }}</p>
    @endif
    <label>Title:</label><p>{{ request()->input('title') }}</p>
    <label>Status:</label><p>{{ request()->input('status') }}</p>
    <label>Content:</label><p>{{ request()->input('content') }}</p>
    <label>City:</label><p>{{ request()->input('city') }}</p>
    <label>District:</label><p>{{ request()->input('district') }}</p>
    <label>Address:</label><p>{{ request()->input('address') }}</p>
    <label>Price:</label><p>{{ request()->input('price') }}</p>
    <label>Area:</label><p>{{ request()->input('area') }}</p>

    <form method="POST" id="input_form" action="{{ route('client.post.update', ['post' => request()->input('id')]) }}">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{ request()->input('id') }}">
        <input type="hidden" name="title" value="{{ request()->input('title') }}">
        <input type="hidden" name="status" value="{{ request()->input('status') }}">
        <input type="hidden" name="content" value="{{ request()->input('content') }}">
        <input type="hidden" name="city" value="{{ request()->input('city') }}">
        <input type="hidden" name="district" value="{{ request()->input('district') }}">
        <input type="hidden" name="address" value="{{ request()->input('address') }}">
        <input type="hidden" name="price" value="{{ request()->input('price') }}">
        <input type="hidden" name="area" value="{{ request()->input('area') }}">
        <input type="hidden" name="client_id" value="{{ request()->input('client_id') }}">
        <div >
            <a id="btn_back_to_edit" href="#" data-post-url="{{ route('client.post.edit', ['post' => request()->input('id')]) }}" >back</a>
            <input type="submit" value="update">
        </div>
    </form>
@stop

@section ('JAVASCRIPT')
    <script>
        // btn_back_to_create
        $('#btn_back_to_edit').on('click', function(e) {
            e.preventDefault();
            var $input_form = $('#input_form');
            $input_form.attr('action', $(this).data('post-url'));
            $input_form.submit();
        });
    </script>
@stop
