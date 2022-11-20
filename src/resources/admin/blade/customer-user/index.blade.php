@extends('main')

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.status-msg')
@stop

@section('page-heading')
    Danh sách khách hàng
@stop

@section('CONTENTS')
    <div class="search-form card">
        <div class="card-header">Tìm kiếm</div>
        <div class="card-body">
            <form class="mb-2" method="GET" action="{{ route('admin.customer-user.index') }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="id" class="col-form-label fw-bold">ID khách hàng: </label>
                        <input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="name" class="col-form-label ps-3 fw-bold">Tên khách hàng: </label>
                        <input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="tel" class="col-form-label fw-bold">Số điện thoại: </label>
                        <input type="text" name="tel" class="form-control" value="{{ Renderer::oldWithRequest('tel') }}">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="address" class="col-form-label ps-3 fw-bold">Địa chỉ: </label>
                        <input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}" class="form-control">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                    </div>
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
                            <th scope="col" width="200">Tên khách hàng</th>
                            <th scope="col" width="150">Số điện thoại</th>
                            <th scope="col" width="150">Email</th>
                            <th scope="col" width="100">Giới tính</th>
                            <th scope="col" width="100">Ngày sinh</th>
                            <th scope="col" width="300">Địa chỉ</th>
                            <th scope="col" width="100">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse(Renderer::getPaginator() ?? [] as $val)
                        <tr>
                            <td><a href="{{ route('admin.customer-user.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                            <td>{{ $val->getName() }}</td>
                            <td>{{ $val->getTel() }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ \App\Common\Customer\Definition\CustomerGender::getName($val->getGender()) }}</td>
                            <td>{{ $val->getBirthday() }}</td>
                            <td>{{ $val->getAddress() }}</td>
                            <td>{{ \App\Common\Customer\Definition\CustomerStatus::getName($val->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="8"><p>Không có kết quả </p></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {!! Renderer::renderPaginator('include.pager') !!}
            </div>
        </div>
    </div>
@stop
