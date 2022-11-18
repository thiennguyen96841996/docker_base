@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Post List
        </h3>
    </div>
    <div class="search-form card">
        <div class="card-header">Search</div>
        <div class="card-body">
            <form class="mb-2" method="GET" action="{{ route('admin.post.index') }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="id" class="col-form-label fw-bold">ID: </label>
                            <div class="flex-fill">
                                <input type="number" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="title" class="col-form-label fw-bold">Title: </label>
                            <div class="flex-fill">
                                <input type="text" name="title" value="{{ Renderer::oldWithRequest('title') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="client_id" class="col-form-label fw-bold">Status: </label>
                            <div class="flex-fill ">
                                <select name="status" class="form-select">
                                    <option value="">--</option>
                                    @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                                        @if (Renderer::oldWithRequest('status') == $status->value)
                                            <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @else
                                            <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="address" class="col-form-label fw-bold">Address: </label>
                            <div class="flex-fill">
                                <input type="text" name="address" class="form-control" value="{{ Renderer::oldWithRequest('address') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="client_id" class="col-form-label fw-bold">Client: </label>
                            <div class="flex-fill ">
                                <input type="number" name="client_id" value="{{ Renderer::oldWithRequest('client_id') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                   
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
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
                        <th scope="col" width="50">Id</th>
                        <th scope="col" width="200">Title</th>
                        <th scope="col" width="300">Address</th>
                        <th scope="col" width="100">Price(VNĐ)</th>
                        <th scope="col" width="50">Area(m2)</th>
                        <th scope="col" width="50">Client</th>
                        <th scope="col" width="50">Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse(Renderer::getPaginator() ?? [] as $val)
                    <tr>
                        <td><a href="{{ route('admin.post.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                        <td>{{ $val->title }}</td>
                        <td>{{ $val->address }}</td>
                        <td>{{ number_format($val->price) }}</td>
                        <td>{{ $val->area }}</td>
                        <td><a href="{{ route('admin.client-user.show', $val->client_id) }}" class="text-link">{{ $val->client_id }}</a></td>
                        <td>{{ \App\Common\Database\Definition\AvailableStatus::getName($val->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="7"><p>No results </p></td>
                    </tr>
                @endforelse
                </tbody>
            </table></div>
            
            {!! Renderer::renderPaginator('include.pager') !!}
        </div>
    </div>
@stop
