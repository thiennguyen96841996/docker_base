@extends ('main')

@section('title', Renderer::getPageTitle())

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.msg.status-msg')
    
    <div class="page-title">
        <h3>
            Post Edit Confirmation
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form id="input_form" method="POST" action="{{ route('admin.post.update', ['post' => request()->input('id')]) }}">
                @method('PUT')    
                @csrf
                <input type="hidden" name="id" value="{{ request()->input('id') }}">
                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ request()->input('title') }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Content</label>
                    <textarea name="content" class="form-control" rows="10" readonly>{{ request()->input('content') }}</textarea>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">City</label>
                        <input type="text" name="city" value="{{ request()->input('city') }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">District</label>
                        <input type="text" name="district" value="{{ request()->input('district') }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="mb-3">
                        <label class="form-label fw-bold">Address</label>
                        <input type="text" name="address" value="{{ request()->input('address') }}" class="form-control" readonly>
                    </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Price (VNĐ)</label>
                        <input type="text" value="{{ number_format(request()->input('price')) }}" class="form-control" readonly>
                        <input type="hidden" name="price" value="{{ request()->input('price') }}" class="form-control" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Area (m2)</label>
                        <input type="number" name="area" value="{{ request()->input('area') }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Published At</label>
                        <input type="text" name="published_at" class="form-control" value="{{ request()->input('published_at') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Closed At</label>
                        <input type="text" name="closed_at" class="form-control" value="{{ request()->input('closed_at') }}" readonly>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Client</label>
                        <input type="text" name="client_id" class="form-control" value="{{ request()->input('client_id') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <input type="text" class="form-control" value="{{ \App\Common\Database\Definition\AvailableStatus::getName(request()->input('status')) }}" readonly>
                        <input type="hidden" name="status" class="form-control" value="{{ request()->input('status') }}" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-end text-center mt-4">
                    <a id="btn_back_to_edit" href="#" data-post-url="{{ route('admin.post.edit', ['post' => request()->input('id')]) }}" class="btn btn-outline-secondary me-2">Back</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

@stop

@section ('JAVASCRIPT')
    <script>
        // btn_back_to_create
        $('#btn_back_to_edit').on('click', function(e) {
            e.preventDefault();
            var $input_form = $('#input_form');
            $input_form.attr('action', $(this).data('post-url'));
            $input_form.submit();
        });
    </script>
@stop
