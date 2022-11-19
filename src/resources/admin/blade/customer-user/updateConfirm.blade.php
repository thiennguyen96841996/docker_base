@extends('main')

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')
    <div class="page-title">
        <h3>
            Customer User {{ request()->input('id') }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="input_form" action="{{ route('admin.customer-user.updateStatus', request()->input('id')) }}">
                @method('PUT')
                @csrf
                <div class="row g-2">
                    <div class="mb-3 col-md-4">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control" value="{{ request()->input('name') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label fw-bold">Gender</label>
                        <input type="text" class="form-control" value="{{ request()->input('gender') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label fw-bold">Status</label>
                        <input type="hidden" name="status" class="form-control" value="{{ request()->input('status') }}" readonly>
                        <input type="text" class="form-control" value="{{ \App\Common\Database\Definition\AvailableStatus::getName(request()->input('status')) }}" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input type="text" class="form-control" value="{{ request()->input('email') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Tel</label>
                        <input type="text" class="form-control" value="{{ request()->input('tel') }}" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Birthday</label>
                        <input type="text" class="form-control" value="{{ request()->input('birthday') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Address</label>
                        <input type="text" class="form-control" value="{{ request()->input('address') }}" readonly>
                    </div>
                </div>
                <div class="d-flex justify-content-end text-center mt-4">
                    <a id="btn_back_to_edit" class="btn btn-outline-secondary me-2" href="#" data-post-url="{{ route('admin.customer-user.edit', request()->input('id')) }}">Back</a>
                    <button type="submit" class="btn btn-primary" value="update"><i class="fas fa-save"></i> Update</button>
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
