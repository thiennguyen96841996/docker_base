@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Post List
        </h3>
    </div>
    <div class="card">
        <div class="card-header">Search</div>
        <div class="card-body  p-4">
            <form class="mb-2" method="GET" action="{{ route('admin.post.index') }}">
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
                            <label for="inputPassword fw-bold ml-3" class="col-sm-2 col-form-label ps-4 fw-bold">Title: </label>
                            <div class="col-sm-10 ps-0">
                                <input type="text" name="title" value="{{ Renderer::oldWithRequest('title') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="row">
                            <label for="inputPassword fw-bold" class="col-sm-2 col-form-label ps-4 fw-bold">Address: </label>
                            <div class="col-sm-10 ps-0 ">
                                <input type="number" name="address" class="form-control" value="{{ Renderer::oldWithRequest('address') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="row">
                            <label for="inputPassword fw-bold ml-3" class="col-sm-2 col-form-label ps-4 fw-bold">Client: </label>
                            <div class="col-sm-10 ps-0 ">
                                <input type="text" name="client_id" value="{{ Renderer::oldWithRequest('client_id') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>  
                </div>
            </form>
        </div>
        
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <div class="table-responsive"><table width="100%" class="table table-striped" id="dataTables-example">
                <thead>
                    <tr>
                        <th scope="col" width="150">Id</th>
                        <th scope="col" width="150">Title</th>
                        <th scope="col" width="150">Status</th>
                        <th scope="col" width="150">City</th>
                        <th scope="col" width="150">District</th>
                        <th scope="col" width="150">Address</th>
                        <th scope="col" width="150">Price</th>
                        <th scope="col" width="150">Area</th>
                        <th scope="col" width="150">Client</th>
                    </tr>
                </thead>
                <tbody>
                @forelse(Renderer::getPaginator() ?? [] as $val)
                    <tr>
                        <td><a href="{{ route('admin.post.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                        <td>{{ $val->title }}</td>
                        <td>{{ $val->status }}</td>
                        <td>{{ $val->city }}</td>
                        <td>{{ $val->district }}</td>
                        <td>{{ $val->address }}</td>
                        <td>{{ $val->price }}</td>
                        <td>{{ $val->area }}</td>
                        <td>{{ $val->client_id }}</td>
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
