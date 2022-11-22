@extends('main')

@php $customerUser = Renderer::get('customerUser') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Thông tin khách hàng {{ $customerUser->id }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">Tên khách hàng</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getName() }}" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">Giới tính</label>
                    <input type="text" class="form-control" value="{{ \App\Common\Database\Definition\Gender::getName($customerUser->getGender()) }}" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <input type="text" class="form-control" value="{{ \App\Common\Database\Definition\AvailableStatus::getName($customerUser->status) }}" readonly>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="text" class="form-control" value="{{ $customerUser->email }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Số điện thoại</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getTel() }}" readonly>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Ngày sinh</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getBirthday() }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Địa chỉ</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getAddress() }}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.customer-user.index') }}" class="btn btn-outline-secondary">Quay lại</a>
        <div class="d-flex justify-content-start text-center">
            <div class="mx-1">
                <a href="{{ route('admin.customer-user.edit', $customerUser->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Chỉnh sửa</a>
            </div>
            <div>
                <form method="POST" name="delete_form" action="{{ route('admin.customer-user.destroy', $customerUser->id) }}" onClick="delete_customer_user('{{ $customerUser->id }}', '{{ $customerUser->getName() }}'); return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Xoá</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/js/customer.js', 'admin') }}"></script>
@stop
