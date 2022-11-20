@extends('main')

@section('title', Renderer::getPageTitle())

@section('page-heading')
    Xác nhận chỉnh sửa thông tin khách hàng
@stop

@section('CONTENTS')
    <div class="card">
        <div class="card-body">
            <form method="POST" id="input_form" action="{{ route('admin.customer-user.updateStatus', request()->input('id')) }}">
                @method('PUT')
                @csrf
                <div class="row g-2">
                    <div class="mb-3 col-md-4">
                        <label class="form-label fw-bold">Tên khách hàng</label>
                        <input type="text" class="form-control" value="{{ request()->input('name') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label fw-bold">Giới tính</label>
                        <input type="text" class="form-control" value="{{ request()->input('gender') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <input type="hidden" name="status" class="form-control" value="{{ request()->input('status') }}" readonly>
                        <input type="text" class="form-control" value="{{ \App\Common\Customer\Definition\CustomerStatus::getName(request()->input('status')) }}" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" value="{{ request()->input('email') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Số điện thoại</label>
                        <input type="text" class="form-control" value="{{ request()->input('tel') }}" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Ngày sinh</label>
                        <input type="text" class="form-control" value="{{ request()->input('birthday') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Địa chỉ</label>
                        <input type="text" class="form-control" value="{{ request()->input('address') }}" readonly>
                    </div>
                </div>
                <div class="d-flex justify-content-end text-center mt-4">
                    <a id="btn_back_to_edit" class="btn btn-outline-secondary me-2" href="#" data-post-url="{{ route('admin.customer-user.edit', request()->input('id')) }}">Quay lại</a>
                    <button type="submit" class="btn btn-primary" value="update"><i class="fas fa-save"></i> Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/js/customer.js', 'admin') }}"></script>
@stop
