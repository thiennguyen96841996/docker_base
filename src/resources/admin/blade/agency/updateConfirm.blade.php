@extends ('main')

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.status-msg')

    <h3>Agency confirm</h3>
    @if (!empty(request()->input('id')))
        <label>ID</label><p>{{ request()->input('id') }}</p>
    @endif
    <label>Name:</label><p>{{ request()->input('name') }}</p>
    <label>Tel:</label><p>{{ request()->input('tel') }}</p>
    <label>Address:</label><p>{{ request()->input('address') }}</p>

    <form method="POST" id="input_form" action="{{ route('admin.agency.update', ['agency' => request()->input('id')]) }}">
        @method('PUT')
        @csrf
        <input type="hidden" name="id" value="{{ request()->input('id') }}">
        <input type="hidden" name="name" value="{{ request()->input('name') }}">
        <input type="hidden" name="tel" value="{{ request()->input('tel') }}">
        <input type="hidden" name="address" value="{{ request()->input('address') }}">
        <div>
            <a id="btn_back_to_edit" href="#" data-post-url="{{ route('admin.agency.edit', ['agency' => request()->input('id')]) }}" >back</a></li>
            <input type="submit" value="update">
        </div>
    </form>
@stop

@section ('JAVASCRIPT')
    <script>
        // btn_back_to_edit
        $('#btn_back_to_edit').on('click', function(e) {
            e.preventDefault();
            var $input_form = $('#input_form');
            $input_form.attr('action', $(this).data('post-url'));
            $input_form.submit();
        });
    </script>
@stop
