@extends('main')

@php
    $customerUser = Renderer::get('customerUser');
    $isBack = Renderer::get('isBack');
    $gender = $isBack ? $customerUser->gender : $customerUser->getGender();
@endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')

    <div class="page-title">
        <h3>
            Chỉnh sửa thông tin khách hàng
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.customer-user.updateConfirm',  $customerUser->id) }}" class="common-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $customerUser->id }}">
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label fw-bold required-mark">Trạng thái </label>
                                <select name="status" class="form-select">
                                    @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                                        @if ($status->value === Renderer::oldOrElse('status', $customerUser))
                                            <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @else
                                            <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="line my-3"></div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label fw-bold">Tên khách hàng</label>
                                <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" value="{{ $isBack ? $customerUser->name : $customerUser->getName() }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Giới tính</label>
                                <input type="text" name="gender" class="form-control" value="{{ \App\Common\Database\Definition\Gender::getName($customerUser->getGender()) }}" readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label fw-bold">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ $customerUser->email }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tel" class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" name="tel" placeholder="0123456789" class="form-control" value="{{ $isBack ? $customerUser->tel : $customerUser->getTel() }}" readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Ngày sinh</label>
                                <input type="text" name="birthday" class="form-control" value="{{ $isBack ? $customerUser->birthday : $customerUser->getBirthday() }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" value="{{ $customerUser->getAddress() }}" readonly>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end text-center mt-4">
                            <a href="{{ route('admin.customer-user.show', $customerUser->id) }}" class="btn btn-outline-secondary me-2">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Tiếp theo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
