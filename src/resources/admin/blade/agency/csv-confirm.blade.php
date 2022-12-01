@extends('main')

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.error-msg')
@stop

@section('page-heading')
    Xác nhận tải lên danh sách đại lý
@stop

@section('CONTENTS')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"></h5>
            <div class="mb-3 col-md-6">
                <label for="csv_file" class="form-label fw-bold">Tên file</label>
                <p>{{ Request::File('csv_file')->getClientOriginalName() }}</p>
            </div>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label fw-bold required-mark">Số bản ghi</label>
                <p>{{ number_format(Renderer::get('csv_row_num')) }}</p>
            </div>

            <form method="POST" action="{{ route('admin.agency.csv-update') }}" class="common-form" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="str_data" value="{{ Renderer::get('str_data') }}">

                <div class="d-flex justify-content-end text-center mt-4">
                    <a href="{{ route('admin.agency.csv-upload') }}" class="btn btn-outline-secondary me-2">Quay lại</a>
                    <button type="submit" class="btn btn-primary" value="update"><i class="fas fa-save"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
@stop
