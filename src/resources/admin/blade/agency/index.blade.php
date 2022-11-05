@extends('main')

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Agency List
        </h3>
    </div>
    <div class="card">
        <div class="card-header">Search</div>
        <div class="card-body  p-4">
            <form class="mb-2" method="GET" action="{{ route('admin.agency.index') }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <div class="row">
                            <label for="inputPassword fw-bold" class="col-sm-2 col-form-label ps-4 fw-bold">ID: </label>
                            <div class="col-sm-10 ps-0">
                                <input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="row">
                            <label for="inputPassword fw-bold ml-3" class="col-sm-2 col-form-label ps-4 fw-bold">Name: </label>
                            <div class="col-sm-10 ps-0">
                                <input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="row">
                            <label for="inputPassword fw-bold" class="col-sm-2 col-form-label ps-4 fw-bold">Tel: </label>
                            <div class="col-sm-10 ps-0 ">
                                <input type="number" name="tel" class="form-control" value="{{ Renderer::oldWithRequest('tel') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="row">
                            <label for="inputPassword fw-bold ml-3" class="col-sm-2 col-form-label ps-4 fw-bold">Address: </label>
                            <div class="col-sm-10 ps-0 ">
                                <input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"> Search</button>
                    </div>  
                </div>
            </form>
        </div>
        
    </div>
    <div class="card mt-5">
        <div class="card-header">
            <a href="{{ route('admin.agency.create') }}" class="btn btn-sm btn-outline-primary float-end"><i class="fas fa-plus-circle"></i> Add</a>
        </div>
        <div class="card-body">
            <div class="table-responsive"><table width="100%" class="table table-striped" id="dataTables-example">
                <thead>
                    <tr>
                        <th scope="col" width="150">Id</th>
                        <th scope="col" width="150">Name</th>
                        <th scope="col" width="150">Tel</th>
                        <th scope="col" width="150">Address</th>
                    </tr>
                </thead>
                <tbody>
                @forelse(Renderer::getPaginator() ?? [] as $val)
                    <tr>
                        <td><a href="{{ route('admin.agency.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                        <td>{{ $val->name }}</td>
                        <td>{{ $val->tel }}</td>
                        <td>{{ $val->address }}</td>
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
