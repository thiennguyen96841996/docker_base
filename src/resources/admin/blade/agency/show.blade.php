@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('title', Renderer::getPageTitle())


@section('CONTENTS')
    @include('include.msg.status-msg')
    @include('include.msg.error-msg')
    <div class="page-title">
        <h3>
            Đại lý {{ $agency->id }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label fw-bold required-mark">Tên đại lý</label>
                    <input type="text" class="form-control" value="{{ $agency->name }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="tel" class="form-label fw-bold required-mark">Sđt</label>
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
        <a href="{{ route('admin.agency.index') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
        <div class="d-flex justify-content-start text-center">
            <div class="mx-1">
                <a href="{{ route('admin.client-user.create', ['agency_id' => $agency->id]) }}" class="btn btn-outline-success"><i class="fas fa-plus-circle"></i> Thêm client</a>
            </div>
            <div class="mx-1">
                <a href="{{ route('admin.agency.edit', $agency->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Chỉnh sửa</a>
            </div>
            <div>
                <form method="POST" name="delete_form" action="{{ route('admin.agency.destroy', $agency->id) }}" onClick="delete_agency('{{ $agency->id }}', '{{ $agency->name }}'); return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Xoá</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            Hợp đồng hiện tại
            @if ($agency->status == \App\Common\Agency\Definition\AgencyStatus::ACTIVE->value)
                <div class="float-end">
                    <a href="{{ route('admin.agency-contract.create', ['agency_id' => $agency->id]) }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tạo mới hợp đồng</a>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive"><table width="100%" class="table table-striped" id="dataTables-example">
                    <thead>
                    <tr>
                        <th scope="col" width="50">Id</th>
                        <th scope="col" width="150">Ngày kí kết hợp đồng</th>
                        <th scope="col" width="100">Ngày kết thúc hợp đồng</th>
                        <th scope="col" width="100">Thời hạn hợp đồng</th>
                        <th scope="col" width="100"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(Renderer::get('getContractNow') ?? [] as $val)
                        <tr>
                            <td><a href="{{ route('admin.agency-contract.show', ['agency_id' => $agency->id, 'agency_contract' => $val->id]) }}" class="text-link">{{ $val->id }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($val->start_date)->format('d-m-Y') }}</td>
                            <td>{{ $val->getEndDate() }}</td>
                            <td>{{ \App\Common\AgencyContract\Definition\AgencyContract::getName($val->expire_in) }}</td>
                            <td>
                                @if ($val->end_date != null && \Carbon\Carbon::parse($val->end_date)->format('Y/m/d') <= \Carbon\Carbon::now()->format('Y/m/d'))
                                @else
                                    @if (\Carbon\Carbon::parse($val->start_date)->format('Y/m/d') <= \Carbon\Carbon::now()->format('Y/m/d'))
                                        <div>
                                            <form method="POST" name="contract_cancel_form" action="{{ route('admin.agency-contract.cancel', ['agency_id' => $agency->id, 'agency_contract' => $val->id]) }}" onClick="contract_cancel('{{ $agency->name }}', '{{ $val->id }}'); return false;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="agency_id" value="{{ $agency->id }}">
                                                <input type="hidden" name="end_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                <input type="hidden" name="status" value="{{ \App\Common\Agency\Definition\AgencyStatus::INACTIVE->value }}">
                                                <button type="submit" class="btn btn-dark"><i class="fas fa-trash-alt"></i>Huỷ hợp đồng</button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="mx-1">
                                            <form method="POST" name="delete_contract_form" action="{{ route('admin.agency-contract.delete', ['agency_id' => $agency->id, 'agency_contract' => $val->id]) }}" onClick="delete_agency_contract('{{ $agency->name }}', '{{ $val->id }}'); return false;">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" value="true" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Xoá hợp đồng</button>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5"><p>Không có hợp đồng nào được kí kết </p></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table></div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">Hợp đồng đã kí kết</div>
        <div class="card-body">
            {!! Renderer::renderPaginator('include.pager') !!}
            <div class="table-responsive"><table width="100%" class="table table-striped" id="dataTables-example">
                    <thead>
                    <tr>
                        <th scope="col" width="50">Id</th>
                        <th scope="col" width="150">Ngày kí kết hợp đồng</th>
                        <th scope="col" width="100">Ngày kết thúc hợp đồng</th>
                        <th scope="col" width="100">Thời hạn hợp đồng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse(Renderer::getPaginator() ?? [] as $val)
                        <tr>
                            <td><a href="{{ route('admin.agency-contract.show', ['agency_id' => $agency->id, 'agency_contract' => $val->id]) }}" class="text-link">{{ $val->id }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($val->start_date)->format('d-m-Y') }}</td>
                            <td>{{ $val->getEndDate() }}</td>
                            <td>{{ \App\Common\AgencyContract\Definition\AgencyContract::getName($val->expire_in) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="4"><p>Không có hợp đồng nào được kí kết</p></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table></div>

            {!! Renderer::renderPaginator('include.pager') !!}
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/js/agency.js', 'admin') }}"></script>
    <script type="application/javascript" src="{{ busting('/js/agency-contract.js', 'admin') }}"></script>
@stop
