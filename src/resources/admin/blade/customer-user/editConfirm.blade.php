@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')

    <h3>Xác nhận chỉnh sửa thông tin khách hàng</h3>
    <p>Tên khách hàng: {{request()->input('name')}}</p>
    <p>Số điện thoại: {{request()->input('tel')}}</p>
    <p>Email: {{request()->input('email')}}</p>
    <p>Ngày sinh: {{request()->input('birthday')}}</p>
    <p>Giới tính: {{request()->input('gender') ? \App\Common\Database\Definition\Gender::getName(request()->input('gender')) : "--" }}</p>
    <p>Địa chỉ: {{request()->input('address')}}</p>
    <form id="confirm-form" method="POST" action="{{ route('admin.customer-user.update', request()->input('id')) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ request()->input('id') }}">
        <input type="hidden" name="name" value="{{ request()->input('name') }}"></br>
        <input type="hidden" name="email" value="{{ request()->input('email') }}"></br>
        <input type="hidden" name="tel" value="{{ request()->input('tel') }}"></br>
        <input type="hidden" name="birthday" value="{{ request()->input('birthday') }}"></br>
        <input type="hidden" name="gender" value="{{ request()->input('gender') }}"></br>
        <input type="hidden" name="address" value="{{ request()->input('address') }}"></br>
        <input type="button" value="Quay lại" data-post-url="{{ route('admin.customer-user.edit', request()->input('id')) }}">
        <input type="submit" value="Cập nhật">
    </form>
@stop

@section('JAVASCRIPT')
    <script>
        $("input[type=button]").on('click', function(e) {
            e.preventDefault();

            let form = $('#confirm-form');
            form.attr('action', $(this).data('post-url'));
            form.submit();
        });
    </script>
@stop
