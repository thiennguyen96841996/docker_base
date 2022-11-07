@extends ('main')

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.msg.status-msg')
    
    <div class="page-title">
        <h3>
        Post Edit Confirmation
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
                    <th scope="row">Title</th>
                    <td>{{ request()->input('title') }}</td>
                </tr>
                <tr>
                    <th scope="row">Status</th>
                    <td>{{ request()->input('status') }}</td>
                </tr>
                <tr>
                    <th scope="row">Content</th>
                    <td>{{ request()->input('content') }}</td>
                </tr>
                <tr>
                    <th scope="row">City</th>
                    <td>{{ request()->input('city') }}</td>
                </tr>
                <tr>
                    <th scope="row">District</th>
                    <td>{{ request()->input('district') }}</td>
                </tr>
                <tr>
                    <th scope="row">Address</th>
                    <td>{{ request()->input('address') }}</td>
                </tr>
                <tr>
                    <th scope="row">Price</th>
                    <td>{{ request()->input('price') }}</td>
                </tr>
                <tr>
                    <th scope="row">Area</th>
                    <td>{{ request()->input('area') }}</td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex d-flex justify-content-center text-center p-3">
            <a id="btn_back_to_edit" class="btn btn-secondary me-2" href="#" data-post-url="{{ route('admin.post.edit', ['post' => request()->input('id')]) }}">back</a>
            <form method="POST" id="input_form" action="{{ route('admin.post.update', ['post' => request()->input('id')]) }}">
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
                <button type="submit" class="btn btn-primary" value="update"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>
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
