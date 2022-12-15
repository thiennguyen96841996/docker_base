@extends('main')

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.status-msg')
@stop

@section('page-heading')
    Danh sách dự án
@stop

@section('CONTENTS')
    <div class="search-form card">
        <div class="card-header">Tìm kiếm</div>
        <div class="card-body">
            <form class="mb-2" method="GET" action="{{ route('admin.project.index') }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="id" class="col-form-label fw-bold">ID dự án: </label>
                        <input type="number" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="client_id" class="col-form-label ps-3 fw-bold">Client: </label>
                        <input type="number" name="client_id" value="{{ Renderer::oldWithRequest('client_id') }}" class="form-control">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="title" class="col-form-label fw-bold">Tiêu đề: </label>
                        <input type="text" name="title" value="{{ Renderer::oldWithRequest('title') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="status" class="col-form-label ps-3 fw-bold">Trạng thái: </label>
                        <select name="status" class="form-select">
                            <option value="">--</option>
                            @foreach(\App\Common\Project\Definition\ProjectStatus::cases() as $status)
                                @if (Renderer::oldWithRequest('status') == $status->value)
                                    <option value="{{$status->value}}" selected>{{\App\Common\Project\Definition\ProjectStatus::getName($status->value)}}</option>
                                @else
                                    <option value="{{$status->value}}">{{\App\Common\Project\Definition\ProjectStatus::getName($status->value)}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="address" class="col-form-label fw-bold">Địa chỉ: </label>
                        <input type="text" name="address" class="form-control" value="{{ Renderer::oldWithRequest('address') }}">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                </div>  
            </form>
        </div>
        
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <div class="table-responsive">
                {!! Renderer::renderPaginator('include.pager') !!}

                <table width="100%" class="table table-striped" id="dataTables-example">
                    <thead>
                        <tr>
                            <th scope="col" width="50">ID</th>
                            <th scope="col" width="200">Tiêu đề</th>
                            <th scope="col" width="300">Địa chỉ</th>
                            <th scope="col" width="100">Giá (VNĐ)</th>
                            <th scope="col" width="50">Diện tích (m2)</th>
                            <th scope="col" width="50">Client</th>
                            <th scope="col" width="50">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse(Renderer::getPaginator() ?? [] as $val)
                        <tr>
                            <td><a href="{{ route('admin.project.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                            <td>{{ $val->title }}</td>
                            <td>{{ $val->address }}</td>
                            <td>{{ number_format($val->price) }}</td>
                            <td>{{ $val->area }}</td>
                            <td><a href="{{ route('admin.client-user.show', $val->client_id) }}" class="text-link">{{ $val->client_id }}</a></td>
                            <td>{{ \App\Common\Project\Definition\ProjectStatus::getName($val->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="7"><p>Không có kết quả </p></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                
                {!! Renderer::renderPaginator('include.pager') !!}
            </div>
        </div>
    </div>
@stop
