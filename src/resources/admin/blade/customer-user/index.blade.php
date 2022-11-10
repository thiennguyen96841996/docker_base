@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Danh sách khách hàng
        </h3>
    </div>
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
            {!! Renderer::renderPaginator('include.pager') !!}
            <div class="table-responsive"><table width="100%" class="table table-striped" id="dataTables-example">
                <thead>
                    <tr>
                        <th scope="col" width="50">ID</th>
                        <th scope="col" width="200">Tên khách hàng</th>
                        <th scope="col" width="150">Số điện thoại</th>
                        <th scope="col" width="150">Email</th>
                        <th scope="col" width="100">Giới tính</th>
                        <th scope="col" width="100">Ngày sinh</th>
                        <th scope="col" width="300">Địa chỉ</th>
                    </tr>
                </thead>
                <tbody>
                @forelse(Renderer::getPaginator() ?? [] as $val)
                    <tr>
                        <td><a href="{{ route('admin.customer-user.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                        <td>{{ $val->getName() }}</td>
                        <td>{{ $val->getTel() }}</td>
                        <td>{{ $val->email }}</td>
                        <td>{{ \App\Common\Database\Definition\Gender::getName($val->getGender()) }}</td>
                        <td>{{ $val->getBirthday() }}</td>
                        <td>{{ $val->getAddress() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6"><p>Không có kết quả </p></td>
                    </tr>
                @endforelse
                </tbody>
            </table></div>
            {!! Renderer::renderPaginator('include.pager') !!}
        </div>
    </div>
@stop
