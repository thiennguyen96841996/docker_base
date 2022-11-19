@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('title', Renderer::getPageTitle())


@section('CONTENTS')
    @include('include.msg.status-msg')
    <div class="page-title">
        <h3>
            Đại lý {{ $agency->id }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label fw-bold required-mark">Tên đại lý</label>
                    <input type="text" class="form-control" value="{{ $agency->name }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="tel" class="form-label fw-bold required-mark">Sđt</label>
                    <input type="text" class="form-control" value="{{ $agency->tel }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <input type="text" class="form-control" value="{{ \App\Common\Agency\Definition\AgencyStatus::getName($agency->status) }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label fw-bold required-mark">Giám đốc đại lý</label>
                    <input type="text" class="form-control" value="{{ $agency->agency_director }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label fw-bold required-mark">Ngày thành lập</label>
                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($agency->establishment_date)->format('Y-m-d') }}" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label fw-bold required-mark">Địa chỉ</label>
                <input type="text" class="form-control" value="{{ $agency->address }}" readonly>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.agency.index') }}" class="btn btn-outline-secondary">Quay lại danh sách</a>
        <div class="d-flex justify-content-start text-center">
            <div class="mx-1">
                <a href="{{ route('admin.agency.edit', $agency->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Chỉnh sửa</a>
            </div>
            <div>
                <form method="POST" name="delete_form" action="{{ route('admin.agency.destroy', $agency->id) }}" onClick="delete_agency('{{ $agency->id }}', '{{ $agency->name }}'); return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Xoá</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script>
        /**
         * agency delete
         * @param {String} agency_id
         * @param {String} agency_name
         */
        function delete_agency(agency_id, agency_name) {
            // 確認ダイアログ用テキスト
            var confirm_txt = '';
            confirm_txt  = 'Bạn có chắc chắn muốn xoá thông tin agency dưới không?\n\n';
            confirm_txt += agency_id + ' : ' + agency_name;
            // 論理削除処理
            if(confirm(confirm_txt)) {
                document.delete_form.submit();
            }
        }
    </script>
@stop
