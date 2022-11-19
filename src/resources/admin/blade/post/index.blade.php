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
                    <div class="mb-3 col-md-4">
                        <label for="id" class="col-form-label fw-bold">ID</label>
                        <input type="number" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="client_id" class="col-form-label fw-bold">Client</label>
                        <input type="number" name="client_id" value="{{ Renderer::oldWithRequest('client_id') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="status" class="col-form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">--</option>
                            @foreach(\App\Common\Post\Definition\PostStatus::cases() as $status)
                                @if (Renderer::oldWithRequest('status') == $status->value)
                                    <option value="{{$status->value}}" selected>{{\App\Common\Post\Definition\PostStatus::getName($status->value)}}</option>
                                @else
                                    <option value="{{$status->value}}">{{\App\Common\Post\Definition\PostStatus::getName($status->value)}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="title" class="col-form-label fw-bold">Title</label>
                        <input type="text" name="title" value="{{ Renderer::oldWithRequest('title') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="address" class="col-form-label fw-bold">Address: </label>
                        <input type="text" name="address" class="form-control" value="{{ Renderer::oldWithRequest('address') }}">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
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
                            <td>{{ \App\Common\Post\Definition\PostStatus::getName($val->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="7"><p>No results </p></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                
                {!! Renderer::renderPaginator('include.pager') !!}
            </div>
        </div>
    </div>
@stop
