@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Danh sách đại lý
        </h3>
    </div>
    <div class="search-form card">
        <div class="card-header">Tìm kiếm</div>
        <div class="card-body">
            <form class="mb-2" method="GET" action="{{ route('admin.agency.index') }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="id" class="col-form-label fw-bold">ID: </label>
                            <div class="flex-fill">
                                <input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="name" class="col-form-label fw-bold">Tên đại lý: </label>
                            <div class="flex-fill">
                                <input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="is_available" class="col-form-label fw-bold">Trạng thái: </label>
                            <div class="flex-fill">
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
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="tel" class="col-form-label fw-bold">Sđt: </label>
                            <div class="flex-fill">
                                <input type="text" name="tel" class="form-control" value="{{ Renderer::oldWithRequest('tel') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="address" class="col-form-label fw-bold">Địa chỉ: </label>
                            <div class="flex-fill">
                                <input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="tel" class="col-form-label fw-bold">Giám đốc đại lý: </label>
                            <div class="flex-fill">
                                <input type="text" name="agency_director" class="form-control" value="{{ Renderer::oldWithRequest('agency_director') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="address" class="col-form-label fw-bold">Ngày thành lập: </label>
                            <div class="flex-fill">
                                <input type="date" name="establishment_date" value="{{ Renderer::oldWithRequest('establishment_date') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header">
            <a href="{{ route('admin.agency.create') }}" class="btn btn-primary float-end"><i class="fas fa-plus-circle"></i> Tạo mới</a>
        </div>
        <div class="card-body">
            {!! Renderer::renderPaginator('include.pager') !!}
            <div class="table-responsive"><table width="100%" class="table table-striped" id="dataTables-example">
                <thead>
                    <tr>
                        <th scope="col" width="50">Id</th>
                        <th scope="col" width="150">Tên đại lý</th>
                        <th scope="col" width="100">Sđt</th>
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
                        <td>{{ \App\Common\Agency\Definition\AgencyStatus::getName($val->status) }}</td>
                        <td>{{ $val->agency_director }}</td>
                        <td>{{ \Carbon\Carbon::parse($val->establishment_date)->format('Y/m/d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4"><p>No results </p></td>
                    </tr>
                @endforelse
                </tbody>
            </table></div>

            {!! Renderer::renderPaginator('include.pager') !!}
        </div>
    </div>
@stop
