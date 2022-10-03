@extends ('main')

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.status-msg')

    <h3>Agency confirm</h3>
    <label>Name:</label><p>{{ request()->input('name') }}</p>
    <label>Tel:</label><p>{{ request()->input('tel') }}</p>
    <label>Address:</label><p>{{ request()->input('address') }}</p>

    <form method="POST" id="input_form" action="{{ route('admin.agency.store') }}">
        @csrf
        <input type="hidden" name="name" value="{{ request()->input('name') }}">
        <input type="hidden" name="tel" value="{{ request()->input('tel') }}">
        <input type="hidden" name="address" value="{{ request()->input('address') }}">
        <div >
            <a id="btn_back_to_create" href="#" data-post-url="{{ route('admin.agency.create') }}" >back</a>
            <input type="submit" value="store">
        </div>
    </form>
@stop

@section ('JAVASCRIPT')
    <script>
        // btn_back_to_create
        $('#btn_back_to_create').on('click', function(e) {
            e.preventDefault();
            var $input_form = $('#input_form');
            $input_form.attr('action', $(this).data('post-url'));
            $input_form.submit();
        });
    </script>
@stop
