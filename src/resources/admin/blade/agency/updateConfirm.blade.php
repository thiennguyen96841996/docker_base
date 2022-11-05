@extends ('main')

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.msg.status-msg')
    
    <div class="page-title">
        <h3>
        Agency Confirmation
        </h3>
    </div>
    <div class="box">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="row">Id</th>
                    <td>{{ request()->input('id') }}</td>
                </tr>
                <tr>
                    <th scope="row">Name</th>
                    <td>{{ request()->input('name') }}</td>
                </tr>
                <tr>
                    <th scope="row">Tel</th>
                    <td>{{ request()->input('tel') }}</td>
                </tr>
                <tr>
                    <th scope="row">Address</th>
                    <td>{{ request()->input('address') }}</td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex d-flex justify-content-center text-center p-3">
            <a id="btn_back_to_edit" class="btn btn-secondary me-2" href="#" data-post-url="{{ route('admin.agency.edit', ['agency' => request()->input('id')]) }}">back</a>
            <form method="POST" id="input_form" action="{{ route('admin.agency.update', ['agency' => request()->input('id')]) }}">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{ request()->input('id') }}">
                <input type="hidden" name="name" value="{{ request()->input('name') }}">
                <input type="hidden" name="tel" value="{{ request()->input('tel') }}">
                <input type="hidden" name="address" value="{{ request()->input('address') }}">
                <button type="submit" class="btn btn-primary" value="update"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>
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
