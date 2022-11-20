@extends('main')

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.status-msg')
@stop

@section('page-heading')
    Danh sách Bookmark
@stop

@section('CONTENTS')
    <div class="search-form card">
        <div class="card-header">Tìm kiếm</div>
        <div class="card-body">
            <form class="mb-2" method="GET" action="{{ route('admin.bookmark.index') }}">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="name" placeholder="Name" value="{{ Renderer::oldWithRequest('name') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tìm kiếm</button>
                    </div>  
                </div>
            </form>
        </div>    
    </div>
    <div class="card mt-5">
        <div class="card-body">
            <div class="table-responsive">
                <table width="100%" class="table table-striped" id="dataTables-example">
                    <thead>
                        <tr>
                            <th scope="col" width="150">Tên</th>
                            <th scope="col" width="150">Link</th>
                            <th scope="col" width="50"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse(Renderer::getPaginator() ?? [] as $val)
                        <tr>
                            <td>{{ $val->name }}</td>
                            <td><a href="{{ $val->link }}" class="text-link">{{ $val->link }}</a></td>
                            <td>
                                <form method="POST" action="{{ route('admin.bookmark.destroy', $val->id) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button class="bookmark-delete-btn btn btn-sm btn-danger mx-2">Xoá</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="3"><p>Không có kết quả </p></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
