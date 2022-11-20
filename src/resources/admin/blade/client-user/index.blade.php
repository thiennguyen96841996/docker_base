@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Client User
        </h3>
    </div>
    <div class="search-form card">
        <div class="card-header">Search</div>
        <div class="card-body">
            <form class="mb-2" method="GET" action="{{ route('admin.client-user.index') }}">
                <div class="row g-2">
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="id" class="form-label fw-bold">ID:</label>
                        <input type="text" name="id" value="{{ Renderer::oldWithRequest('id') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="tel" class="form-label ps-3 fw-bold">Tel:</label>
                        <input type="text" name="tel" class="form-control" value="{{ Renderer::oldWithRequest('tel') }}">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="name" class="col-form-label fw-bold">Name:</label>
                        <input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}" class="form-control">
                    </div>
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="email" class="col-form-label ps-3 fw-bold">Email:</label>
                        <input type="text" name="email" value="{{ Renderer::oldWithRequest('email') }}" class="form-control">
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6 d-flex">
                        <label for="status" class="form-label fw-bold">Status:</label>
                        <select name="status" class="form-select">
                            <option value="">--</option>
                            @foreach(\App\Common\ClientUser\Definition\ClientStatus::cases() as $status)
                                @if (Renderer::oldWithRequest('status') == $status->value)
                                    <option value="{{$status->value}}" selected>{{\App\Common\ClientUser\Definition\ClientStatus::getName($status->value)}}</option>
                                @else
                                    <option value="{{$status->value}}">{{\App\Common\ClientUser\Definition\ClientStatus::getName($status->value)}}</option>
                                @endif
                            @endforeach
                        </select>
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
                            <th scope="col" width="80">Id</th>
                            <th scope="col" width="150">Name</th>
                            <th scope="col" width="150">Tel</th>
                            <th scope="col" width="150">Email</th>
                            <th scope="col" width="150">Status</th>
                            <th scope="col" width="150">Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse(Renderer::getPaginator() ?? [] as $val)
                        <tr>
                            <td><a href="{{ route('admin.client-user.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                            <td>{{ $val->getName() }}</td>
                            <td>{{ $val->getTel() }}</td>
                            <td>{{ $val->email }}</td>
                            <td>{{ \App\Common\ClientUser\Definition\ClientStatus::getName($val->status) }}</td>
                            <td>{{ $val->getCreatedAt() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="6"><p>No results </p></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {!! Renderer::renderPaginator('include.pager') !!}
            </div>
        </div>
    </div>
@stop
