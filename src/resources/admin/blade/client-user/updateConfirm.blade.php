@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')
    <div class="page-title">
        <h3>
            Client Edit Confirmation
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="input_form" action="{{ route('admin.client-user.update', request()->input('id')) }}">
                @method('PUT')
                @csrf
                <div class="row g-2">
                    <input type="hidden" name="id" value="{{ request()->input('id') }}">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ request()->input('name') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="region_code" class="form-label fw-bold">Region</label>
                        <input type="text" name="region_code" class="form-control" value="{{ request()->input('region_code') }}" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="tel" class="form-label fw-bold">Tel</label>
                        <input type="text" name="tel" class="form-control" value="{{ request()->input('tel') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="hotline" class="form-label fw-bold">Hotline</label>
                        <input type="text" name="hotline" class="form-control" value="{{ request()->input('hotline') }}" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="status_text" class="form-label fw-bold">Status</label>
                        <input type="text" name="status_text" class="form-control" value="{{ \App\Common\ClientUser\Definition\ClientStatus::getName(request()->input('status')) }}" readonly>
                        <input type="hidden" name="status" value="{{ request()->input('status') }}">
                    </div>
                </div>
                <div class="line my-3"></div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ request()->input('email') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="agency_name" class="form-label fw-bold">Agency</label>
                        <input type="text" name="agency_name" class="form-control" value="{{ request()->input('agency_name') }}" readonly>
                        <input type="hidden" name="agency_id" value="{{ request()->input('agency_id') }}"></br>
                    </div>
                </div>
               
                <div class="d-flex justify-content-end text-center mt-4">
                    <a id="btn_back_to_edit" class="btn btn-outline-secondary me-2" href="#" data-post-url="{{ route('admin.client-user.edit', request()->input('id')) }}">Back</a>
                    <button type="submit" class="btn btn-primary" value="update"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/js/client.js', 'admin') }}"></script>
@stop
