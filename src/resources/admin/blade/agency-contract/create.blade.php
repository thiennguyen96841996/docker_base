@extends('main')

@php $agency = Renderer::get('agencyContract') @endphp

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.error-msg')
@stop

@section('page-heading')
    Tạo mới hợp đồng đại lý {{ request()->agency_id }}
@stop

@section('CONTENTS')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"></h5>
            <form method="POST" action="{{ route('admin.agency-contract.createConfirm', ['agency_id' => request()->agency_id]) }}" class="common-form">
                @csrf
                <input type="hidden" name="agency_id" value="{{ request()->agency_id }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="expire_in" class="form-label fw-bold required-mark">Thời hạn hợp đồng</label>
                        <select id="contract_term" name="expire_in" class="form-select">
                            @foreach(\App\Common\AgencyContract\Definition\AgencyContract::cases() as $status)
                                @if (!empty($agencyContract) && Renderer::oldOrElse('expire_in', $agencyContract) == $status->value)
                                    <option value="{{$status->value}}" selected>{{\App\Common\AgencyContract\Definition\AgencyContract::getName($status->value)}}</option>
                                @else
                                    <option value="{{$status->value}}">{{\App\Common\AgencyContract\Definition\AgencyContract::getName($status->value)}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="start_date" class="form-label fw-bold required-mark">Ngày kí kết hợp đồng</label>
                        <input id="contract_sign_date" type="date" name="start_date" class="form-control" value="{{ Renderer::oldOrElse('start_date', $agency) }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="end_date" class="form-label fw-bold">Ngày kết thúc hợp đồng</label>
                        <input id="contract_cancel_date" type="text" name="end_date" class="form-control" value="{{ Renderer::oldOrElse('end_date', $agency) }}" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-end text-center mt-4">
                    <a href="{{ route('admin.agency.show', request()->agency_id) }}" class="btn btn-outline-secondary me-2">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Tiếp tục</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/js/agency-contract.js', 'admin') }}"></script>
@stop
