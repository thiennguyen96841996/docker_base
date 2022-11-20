@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')
    <div class="page-title">
        <h3>
            Tạo mới đại lý
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"></h5>
            <form method="POST" action="{{ route('admin.agency.createConfirm') }}" class="common-form">
                @csrf
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label fw-bold required-mark">Tên đại lý</label>
                        <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" value="{{ Renderer::oldOrElse('name', $agency) }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="tel" class="form-label fw-bold required-mark">Sđt</label>
                        <input type="text" name="tel" placeholder="0123456789" class="form-control" value="{{ Renderer::oldOrElse('tel', $agency) }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="status" class="form-label fw-bold required-mark">Trạng thái</label>
                        <select name="status" class="form-select">
                            @foreach(\App\Common\Agency\Definition\AgencyStatus::cases() as $status)
                                @if (!empty($agency) && Renderer::oldOrElse('status', $agency) == $status->value)
                                    <option value="{{$status->value}}" selected>{{\App\Common\Agency\Definition\AgencyStatus::getName($status->value)}}</option>
                                @else
                                    <option value="{{$status->value}}">{{\App\Common\Agency\Definition\AgencyStatus::getName($status->value)}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="agency_director" class="form-label fw-bold required-mark">Giám đốc đại lý</label>
                        <input type="text" name="agency_director" class="form-control" placeholder="Nguyễn Văn A" value="{{ Renderer::oldOrElse('agency_director', $agency) }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="establishment_date" class="form-label fw-bold required-mark">Ngày thành lập</label>
                        <input type="date" name="establishment_date" class="form-control" value="{{ Renderer::oldOrElse('establishment_date', $agency) }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label fw-bold required-mark">Địa chỉ</label>
                    <input type="text" name="address" placeholder="Số 1 Đ. Trần Duy Hưng, Trung Hoà, Quận Cầu Giấy, TP Hà Nội" class="form-control" value="{{ Renderer::oldOrElse('address', $agency) }}">
                </div>

                <div class="d-flex justify-content-end text-center mt-4">
                    <a href="{{ route('admin.agency.index') }}" class="btn btn-outline-secondary me-2">Quay lại danh sách</a>
                    <button type="submit" class="btn btn-primary">Tiếp tục</button>
                </div>
            </form>
        </div>
    </div>
@stop
