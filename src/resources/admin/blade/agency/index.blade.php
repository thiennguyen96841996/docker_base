@extends('main')

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.status-msg')
@stop

@section('page-heading')
    Danh sách đại lý
@stop

@section('CONTENTS')
    <div class="search-form card">
        <div class="card-header">Tìm kiếm</div>
        <div class="card-body">
            <form id="search_form" class="mb-2" method="GET" action="{{ route('admin.agency.index') }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="id" class="col-form-label fw-bold">ID đại lý: </label>
                        <input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="name" class="col-form-label ps-3 fw-bold">Tên đại lý: </label>
                        <input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="is_available" class="col-form-label fw-bold">Trạng thái: </label>
                        <select name="status" class="form-select">
                            <option value="" selected>--</option>
                            @foreach(\App\Common\Agency\Definition\AgencyStatus::cases() as $status)
                                @if (Renderer::oldWithRequest('status') == $status->value)
                                    <option value="{{$status->value}}" selected>{{\App\Common\Agency\Definition\AgencyStatus::getName($status->value)}}</option>
                                @else
                                    <option value="{{$status->value}}">{{\App\Common\Agency\Definition\AgencyStatus::getName($status->value)}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="tel" class="col-form-label ps-3 fw-bold">Số điện thoại: </label>
                        <input type="text" name="tel" class="form-control" value="{{ Renderer::oldWithRequest('tel') }}">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="address" class="col-form-label fw-bold">Địa chỉ: </label>
                        <input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="tel" class="col-form-label ps-3 fw-bold">Giám đốc đại lý: </label>
                        <input type="text" name="agency_director" class="form-control" value="{{ Renderer::oldWithRequest('agency_director') }}">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="address" class="col-form-label fw-bold">Ngày thành lập: </label>
                        <input type="date" name="establishment_date" value="{{ Renderer::oldWithRequest('establishment_date') }}" class="form-control">
                    </div>
                    <div class="text-end">
                        <input id="btn_agency_csv" type="button" value="Csv Download" class="btn btn-outline-primary" />
                        <button id="btn_search" type="button" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center float-end">
                <div class="d-flex justify-content-start text-center">
                    <div class="mx-1"><a href="{{ route('admin.agency.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tạo mới</a></div>
                    <div><a href="{{ route('admin.agency.csv-upload') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Csv Upload</a></div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {!! Renderer::renderPaginator('include.pager') !!}
                <table width="100%" class="table table-striped" id="dataTables-example">
                    <thead>
                        <tr>
                            <th scope="col" width="50">ID</th>
                            <th scope="col" width="150">Tên đại lý</th>
                            <th scope="col" width="100">Số điện thoại</th>
                            <th scope="col" width="300">Địa chỉ</th>
                            <th scope="col" width="100">Trạng thái</th>
                            <th scope="col" width="150">Giám đốc đại lý</th>
                            <th scope="col" width="100">Ngày thành lập</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse(Renderer::getPaginator() ?? [] as $val)
                        <tr>
                            <td><a href="{{ route('admin.agency.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                            <td>{{ $val->name }}</td>
                            <td>{{ $val->tel }}</td>
                            <td>{{ $val->address }}</td>
                            <td>{{ $val->getStatus() }}</td>
                            <td>{{ $val->agency_director }}</td>
                            <td>{{ $val->getEstablishmentDate() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="4"><p>Không có kết quả </p></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {!! Renderer::renderPaginator('include.pager') !!}
            </div>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/js/agency.js', 'admin') }}"></script>
@stop
