@extends ('main')

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.msg.status-msg')
    
    <div class="page-title">
        <h3>
        Agency Edit Confirmation
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="input_form" action="{{ route('admin.agency.update', ['agency' => request()->input('id')]) }}">
                @method('PUT')
                @csrf
                <div class="row g-2">
                    <input type="hidden" name="id" value="{{ request()->input('id') }}">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label fw-bold required-mark">Agency Name</label>
                        <input type="text" name="name" class="form-control" value="{{ request()->input('name') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="tel" class="form-label fw-bold required-mark">Tel</label>
                        <input type="text" name="tel" class="form-control" value="{{ request()->input('tel') }}" readonly>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label fw-bold required-mark">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ request()->input('address') }}" readonly>
                </div>
                
                <div class="d-flex justify-content-end text-center mt-4">
                    <a id="btn_back_to_edit" class="btn btn-outline-secondary me-2" href="#" data-post-url="{{ route('admin.agency.edit', ['agency' => request()->input('id')]) }}">Back</a>
                    <button type="submit" class="btn btn-primary" value="update"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script>
        // btn_back_to_edit
        $('#btn_back_to_edit').on('click', function(e) {
            e.preventDefault();
            var $input_form = $('#input_form');
            $input_form.attr('action', $(this).data('post-url'));
            $input_form.submit();
        });
    </script>
@stop
