@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.error-msg')
@stop

@section('page-heading')
    Chỉnh sửa đại lý {{ $agency->id }}
@stop

@section('CONTENTS')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"></h5>
            <form method="POST" action="{{ route('admin.agency.updateConfirm', ['agency' => $agency->id]) }}" class="common-form">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{ $agency->id }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label fw-bold required-mark">Tên đại lý</label>
                        <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" value="{{ Renderer::oldOrElse('name', $agency) }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="tel" class="form-label fw-bold required-mark">Số điện thoại</label>
                        <input type="text" name="tel" placeholder="0123456789" class="form-control" value="{{ Renderer::oldOrElse('tel', $agency) }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="status" class="form-label fw-bold required-mark">Trạng thái</label>
                        <select name="status" class="form-select">
                            @foreach(\App\Common\Agency\Definition\AgencyStatus::cases() as $status)
                                @if ($status->value === Renderer::oldOrElse('status', $agency))
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
                        <input type="date" name="establishment_date" class="form-control" value="{{ \Carbon\Carbon::parse(Renderer::oldOrElse('establishment_date', $agency))->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label fw-bold required-mark">Địa chỉ</label>
                    <input type="text" name="address" placeholder="Số 1 Đ. Trần Duy Hưng, Trung Hoà, Quận Cầu Giấy, TP Hà Nội" class="form-control" value="{{ Renderer::oldOrElse('address', $agency) }}">
                </div>

                <div class="d-flex justify-content-end text-center mt-4">
                    <a href="{{ route('admin.agency.show', $agency->id) }}" class="btn btn-outline-secondary me-2">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Tiếp tục</button>
                </div>
            </form>
        </div>
    </div>
@stop
