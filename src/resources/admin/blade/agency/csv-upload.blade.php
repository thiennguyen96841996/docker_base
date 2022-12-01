@extends('main')

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.error-msg')
@stop

@section('page-heading')
    Upload danh sách đại lý
@stop

@section('CONTENTS')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"></h5>
            <form method="POST" action="{{ route('admin.agency.csv-confirm') }}" class="common-form" enctype="multipart/form-data">
                @csrf
                <div class="row g-2">
                    <div class="mb-6 col-md-6">
                        <label for="csv_file" class="form-label fw-bold required-mark">CSV File</label>
                        <input type="file" name="csv_file">
                    </div>
                </div>

                <div class="d-flex justify-content-end text-center mt-4">
                    <a href="{{ route('admin.agency.index') }}" class="btn btn-outline-secondary me-2">Quay lại</a>
                    <button type="submit" class="btn btn-primary">Tiếp tục</button>
                </div>
            </form>
        </div>
    </div>
@stop
