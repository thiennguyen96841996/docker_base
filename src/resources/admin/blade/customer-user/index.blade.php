@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <!-- <h3>Customer list</h3>
    <form method="GET" action="{{ route('admin.customer-user.index') }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldWithRequest('tel') }}">
        <label>Email:</label><input type="text" name="email" value="{{ Renderer::oldWithRequest('email') }}">
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}">
        <input type="submit" value="search">
    </form> -->
    <!-- <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Tel</th>
            <th>Email</th>
            <th>Address</th>
            <th>Birthday</th>
            <th>Gender</th>
        </tr>
        </thead>
        <tbody>
        @forelse(Renderer::getPaginator() ?? [] as $val)
            <tr>
                <td><a href="{{ route('admin.customer-user.show', $val->id) }}">{{ $val->id }}</a></td>
                <td>{{ $val->getName() }}</td>
                <td>{{ $val->getTel() }}</td>
                <td>{{ $val->email }}</td>
                <td>{{ $val->getAddress() }}</td>
                <td>{{ $val->getGender() }}</td>
                <td>{{ $val->getBirthday() }}</td>
                
                <td><a href="{{ route('admin.customer-user.edit', $val->id) }}">Edit</a></td>
                <td>
                    <form method="POST" action="{{ route('admin.customer-user.destroy', $val->id) }}">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" onclick="return confirm('Do you want to delete this client user?');">
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td>データがありません</td>
            </tr>
        @endforelse
        </tbody>
    </table> -->

    <div class="page-title">
        <h3>
            Customer List
        </h3>
    </div>
    <div class="search-form card">
        <div class="card-header">Search</div>
        <div class="card-body">
            <form class="mb-2" method="GET" action="{{ route('admin.customer-user.index') }}">
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
                            <label for="name" class="col-form-label ps-3 fw-bold">Name: </label>
                            <div class="flex-fill">
                                <input type="text" name="name" value="{{ Renderer::oldWithRequest('name') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="tel" class="col-form-label fw-bold">Tel: </label>
                            <div class="flex-fill">
                                <input type="text" name="tel" class="form-control" value="{{ Renderer::oldWithRequest('tel') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="d-flex">
                            <label for="address" class="col-form-label ps-3 fw-bold">Address: </label>
                            <div class="flex-fill">
                                <input type="text" name="address" value="{{ Renderer::oldWithRequest('address') }}" class="form-control">
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
                        <th scope="col" width="200">Name</th>
                        <th scope="col" width="150">Tel</th>
                        <th scope="col" width="150">Email</th>
                        <th scope="col" width="100">Gender</th>
                        <th scope="col" width="100">Birthday</th>
                        <th scope="col" width="300">Address</th>
                    </tr>
                </thead>
                <tbody>
                @forelse(Renderer::getPaginator() ?? [] as $val)
                    <tr>
                        <td><a href="{{ route('admin.customer-user.show', $val->id) }}" class="text-link">{{ $val->id }}</a></td>
                        <td>{{ $val->getName() }}</td>
                        <td>{{ $val->getTel() }}</td>
                        <td>{{ $val->email }}</td>
                        <td>{{ $val->getGender() }}</td>
                        <td>{{ $val->getBirthday() }}</td>
                        <td>{{ $val->getAddress() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6"><p>No results </p></td>
                    </tr>
                @endforelse
                </tbody>
            </table></div>
            {!! Renderer::renderPaginator('include.pager') !!}
        </div>
    </div>
@stop
