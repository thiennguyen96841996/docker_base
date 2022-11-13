@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')

    <div class="page-title">
        <h3>
            Client create Confirmation
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="input_form" action="{{ route('admin.client-user.store') }}">
                @csrf
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label fw-bold required-mark">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ request()->input('name') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="tel" class="form-label fw-bold required-mark">Tel</label>
                        <input type="text" name="tel" class="form-control" value="{{ request()->input('tel') }}" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label fw-bold required-mark">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ request()->input('email') }}" readonly>
                    </div>
                    <input type="hidden" name="is_available" value="{{ request()->input('is_available') }}">
                    <div class="mb-3 col-md-6">
                        <label for="is_available" class="form-label fw-bold required-mark">Status</label>
                        <input type="text" name="is_available_text" class="form-control" value="{{ \App\Common\Database\Definition\AvailableStatus::getName(request()->input('is_available')) }}" readonly>
                    </div>
                    <!-- <input type="hidden" name="agency_id" value="{{ request()->input('agency_id') }}"></br> -->
                </div>
                <div>
                    <input type="hidden" name="agency_id" value="{{ request()->input('agency_id') }}"></br>
                    <label for="agency_name" class="form-label fw-bold required-mark">Agency</label>
                    <input type="text" name="agency_name" class="form-control" value="{{ $agency->name }}" readonly>
                </div>
                <!-- <input type="hidden" name="password" value="{{ request()->input('password') }}"></br> -->
                <div class="d-flex justify-content-end text-center mt-4">
                    <a id="btn_back_to_edit" class="btn btn-outline-secondary me-2" href="#" data-post-url="{{ route('admin.client-user.create') }}">Back</a>
                    <button type="submit" class="btn btn-primary" value="update"><i class="fas fa-save"></i> Create</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('JAVASCRIPT')
    <script>
        $("input[type=button]").on('click', function(e) {
            e.preventDefault();

            let form = $('#confirm-form');
            form.attr('action', $(this).data('post-url'));
            form.submit();
        });
    </script>
@stop
