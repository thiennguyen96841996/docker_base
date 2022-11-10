@extends('main')

@php $agencyContract = Renderer::get('agencyContract'); $agency = Renderer::get('agency') @endphp

@section('title', Renderer::getPageTitle())


@section('CONTENTS')
    @include('include.msg.status-msg')
    <div class="page-title">
        <h3>
            Hợp đồng {{ $agencyContract->id }} đại lý {{ $agencyContract->agency_id }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Thời hạn hợp đồng</label>
                    <input type="text" class="form-control" value="{{ \App\Common\AgencyContract\Definition\AgencyContract::getName($agencyContract->expire_in) }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="start_date" class="form-label fw-bold required-mark">Ngày kí kết hợp đồng</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($agencyContract->start_date)->format('d-m-Y') }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="start_date" class="form-label fw-bold required-mark">Ngày kết thúc hợp đồng</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($agencyContract->end_date)->format('d-m-Y') }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Thông tin đại lý
        </div>
        <div class="card-body">
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label fw-bold required-mark">Tên đại lý</label>
                    <input type="text" class="form-control" value="{{ $agency->name }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="tel" class="form-label fw-bold required-mark">Số điện thoại</label>
                    <input type="text" class="form-control" value="{{ $agency->tel }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <input type="text" class="form-control" value="{{ \App\Common\Agency\Definition\AgencyStatus::getName($agency->status) }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label fw-bold required-mark">Giám đốc đại lý</label>
                    <input type="text" class="form-control" value="{{ $agency->agency_director }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label fw-bold required-mark">Ngày thành lập</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($agency->establishment_date)->format('Y-m-d') }}" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label fw-bold required-mark">Địa chỉ</label>
                <input type="text" class="form-control" value="{{ $agency->address }}" readonly>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.agency.show', $agency->id) }}" class="btn btn-outline-secondary">Quay lại</a>
        <div class="d-flex justify-content-start text-center">
            @if ($agencyContract->end_date != null && \Carbon\Carbon::parse($agencyContract->end_date)->format('Y/m/d') <= \Carbon\Carbon::now()->format('Y/m/d'))
            @else
                @if (\Carbon\Carbon::parse($agencyContract->start_date)->format('Y/m/d') < \Carbon\Carbon::now()->format('Y/m/d'))
                    <div>
                        <form method="POST" name="contract_cancel_form" action="{{ route('admin.agency-contract.cancel', ['agency_id' => $agency->id, 'agency_contract' => $agencyContract->id]) }}" onClick="contract_cancel('{{ $agency->name }}', '{{ $agencyContract->id }}'); return false;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="agency_id" value="{{ $agency->id }}">
                            <input type="hidden" name="end_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            <input type="hidden" name="status" value="{{ \App\Common\Agency\Definition\AgencyStatus::INACTIVE->value }}">
                            <button type="submit" class="btn btn-dark"><i class="fas fa-trash-alt"></i>Huỷ hợp đồng</button>
                        </form>
                    </div>
                @else
                    <div>
                        <form method="POST" name="delete_contract_form" action="{{ route('admin.agency-contract.delete', ['agency_id' => $agency->id, 'agency_contract' => $agencyContract->id]) }}" onClick="delete_agency_contract('{{ $agency->name }}', '{{ $agencyContract->id }}'); return false;">
                            @method('DELETE')
                            @csrf
                            <button type="submit" value="true" class="btn btn-danger"><i class="fas fa-trash-alt"></i>Xoá hợp đồng</button>
                        </form>
                    </div>
                @endif
            @endif
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/js/agency-contract.js', 'admin') }}"></script>
@stop
