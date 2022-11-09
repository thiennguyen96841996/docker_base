@extends ('main')

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
        Agency Create Confirmation
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="input_form" action="{{ route('admin.agency.store') }}">
                @csrf
                <div class="row g-2">
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
                    <a id="btn_back_to_create" class="btn btn-outline-secondary me-2" href="#" data-post-url="{{ route('admin.agency.create') }}" >Back</a>
                    <button type="submit" class="btn btn-primary" value="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script>
        // btn_back_to_create
        $('#btn_back_to_create').on('click', function(e) {
            e.preventDefault();
            var $input_form = $('#input_form');
            $input_form.attr('action', $(this).data('post-url'));
            $input_form.submit();
        });
    </script>
@stop
