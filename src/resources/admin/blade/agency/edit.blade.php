@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')
    <div class="page-title">
        <h3>
            Agency Edit
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.agency.updateConfirm', ['agency' => $agency->id]) }}" class="common-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $agency->id }}">
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label fw-bold required-mark">Agency Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" value="{{ Renderer::oldOrElse('name', $agency) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tel" class="form-label fw-bold required-mark">Tel</label>
                                <input type="text" name="tel" placeholder="0123456789" class="form-control" value="{{ Renderer::oldOrElse('tel', $agency) }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold required-mark">Address</label>
                            <input type="text" name="address" placeholder="Số 1 Đ. Trần Duy Hưng, Trung Hoà, Quận Cầu Giấy, TP Hà Nội" class="form-control" value="{{ Renderer::oldOrElse('address', $agency) }}">
                        </div>
                       
                        <div class="d-flex justify-content-end text-center mt-4">
                            <a href="{{ route('admin.agency.show', $agency->id) }}" class="btn btn-outline-secondary me-2">Back to show</a>
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
