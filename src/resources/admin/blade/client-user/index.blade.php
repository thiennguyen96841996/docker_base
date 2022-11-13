@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="container">
        <div class="page-title">
            <h3>
                Client User
            </h3>
        </div>
        <div class="search-form card">
            <div class="card-header">Search</div>
            <div class="card-body">
                <form class="mb-2" method="GET" action="{{ route('admin.client-user.index') }}">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <div class="d-flex">
                                <label for="id" class="col-form-label fw-bold">ID: </label>
                                <div class="flex-fill">
                                    <input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <div class="d-flex">
                                <label for="tel" class="col-form-label fw-bold">Tel: </label>
                                <div class="flex-fill">
                                    <input type="te4xt" name="tel" class="form-control" value="{{ Renderer::oldWithRequest('tel') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <div class="d-flex">
                                <label for="is_available" class="col-form-label fw-bold">Status: </label>
                                <div class="flex-fill">
                                    <select name="is_available" class="form-select">
                                        <option value="" selected>Choose...</option>
                                    @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                                        @if (Renderer::oldWithRequest('is_available') == $status->value)
                                            <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @else
                                            <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="mb-3 col-md-6">
                            <div class="d-flex">
                                <label for="name" class="col-form-label fw-bold">Name: </label>
                                <div class="flex-fill">
                                    <input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="d-flex">
                                <label for="email" class="col-form-label fw-bold">Email: </label>
                                <div class="flex-fill">
                                    <input type="text" name="email" value="{{ Renderer::oldWithRequest('email') }}" class="form-control">
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
            <div class="card-header">
                <a href="{{ route('admin.client-user.create') }}" class="btn btn-primary float-end"><i class="fas fa-plus-circle"></i> Add</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {!! Renderer::renderPaginator('include.pager') !!}
                    <table width="100%" class="table table-striped" id="dataTables-example">
                        <thead>
                            <tr>
                                <th scope="col" width="80">Id</th>
                                <th scope="col" width="150">Name</th>
                                <th scope="col" width="150">Tel</th>
                                <th scope="col" width="150">Email</th>
                                <th scope="col" width="150">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse(Renderer::getPaginator() ?? [] as $val)
                            <tr>
                                <td><a href="{{ route('admin.client-user.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                                <td>{{ $val->getName() }}</td>
                                <td>{{ $val->getTel() }}</td>
                                <td>{{ $val->email }}</td>
                                <td>{{ \App\Common\Database\Definition\AvailableStatus::getName($val->is_available) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="5"><p>No results </p></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {!! Renderer::renderPaginator('include.pager') !!}
                </div>
            </div>
        </div>
    </div>
@stop
