@extends ('main')

@section('title', Renderer::getPageTitle())

{{-- Contents --}}
@section ('CONTENTS')
    {{-- エラーメッセージ --}}
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
        Xác nhận tạo mới hợp đồng đại lý {{ request()->input('agency_id') }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="POST" id="input_form" action="{{ route('admin.agency-contract.store', ['agency_id' => request()->input('agency_id')]) }}">
                @csrf
                <div class="row g-2">
                    <input type="hidden" name="agency_id" value="{{ request()->input('agency_id') }}">
                    <div class="mb-3 col-md-6">
                        <input type="hidden" name="expire_in" value="{{ request()->input('expire_in') }}">
                        <label for="expire_in" class="form-label fw-bold required-mark">Thời hạn hợp đồng</label>
                        <input type="text" name="expire_in_text" class="form-control" value="{{ \App\Common\AgencyContract\Definition\AgencyContract::getName(request()->input('expire_in')) }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="start_date" class="form-label fw-bold required-mark">Ngày kí kết hợp đồng</label>
                        <input type="text" name="start_date" class="form-control" value="{{ request()->input('start_date') }}" readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="end_date" class="form-label fw-bold required-mark">Ngày kết thúc hợp đồng</label>
                        <input type="text" name="end_date" class="form-control" value="{{ request()->input('end_date') }}" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-end text-center mt-4">
                    <a id="btn_back_to_create" class="btn btn-outline-secondary me-2" href="#" data-post-url="{{ route('admin.agency-contract.create', ['agency_id' => request()->input('agency_id')]) }}" >Quay lại</a>
                    <button type="submit" class="btn btn-primary" value="submit"><i class="fas fa-save"></i> Lưu</button>
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
