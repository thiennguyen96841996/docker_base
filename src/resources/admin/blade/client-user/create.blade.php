@extends('main')

@php 
    $agency = Renderer::get('agency');
    $clientUser = Renderer::get('clientUser');
@endphp

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.error-msg')
@stop

@section('page-heading')
    Tạo mới nhân viên
@stop

@section('CONTENTS')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.client-user.createConfirm') }}" class="common-form">
                        @csrf
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label fw-bold required-mark">Tên nhân viên</label>
                                <input type="text" name="name" class="form-control" value="{{ Renderer::oldOrElse('name', $clientUser) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="region_code" class="form-label fw-bold required-mark">Khu vực</label>
                                <input type="text" name="region_code" class="form-control" value="{{ Renderer::oldOrElse('region_code', $clientUser) }}">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="tel" class="form-label fw-bold required-mark">Số điện thoại</label>
                                <input type="text" name="tel" class="form-control" value="{{ Renderer::oldOrElse('tel', $clientUser) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="hotline" class="form-label fw-bold required-mark">Hotline</label>
                                <input type="text" name="hotline" class="form-control" value="{{ Renderer::oldOrElse('hotline', $clientUser) }}">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label fw-bold required-mark">Trạng thái</label>
                                <select name="status" class="form-select">
                                    @foreach(\App\Common\ClientUser\Definition\ClientStatus::cases() as $status)
                                        @if (!empty($clientUser) && Renderer::oldOrElse('status', $clientUser) == $status->value)
                                            <option value="{{$status->value}}" selected>{{\App\Common\ClientUser\Definition\ClientStatus::getName($status->value)}}</option>
                                        @else
                                            <option value="{{$status->value}}">{{\App\Common\ClientUser\Definition\ClientStatus::getName($status->value)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label fw-bold required-mark">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ Renderer::oldOrElse('email', $clientUser) }}">
                            </div>
                        </div>
                        <div class="line my-3"></div>
                        <div class="mb-3">
                            <label for="agency_name" class="form-label fw-bold">Đại lý</label>
                            <input type="text" name="agency_name" class="form-control" value="{{ $agency->name }}" readonly>
                            <input type="hidden" name="agency_id" class="form-control" value="{{ $agency->id }}">
                        </div>
                        <div class="d-flex justify-content-end text-center mt-4">
                            <a href="{{ route('admin.client-user.index') }}" class="btn btn-outline-secondary me-2">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Tiếp theo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
