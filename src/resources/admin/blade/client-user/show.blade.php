@extends('main')

@php $clientUser = Renderer::get('clientUser') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')
    <div class="page-title">
        <h3>
            Client User {{ $clientUser->id }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" class="form-control" value="{{ $clientUser->getName() }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <input type="text" class="form-control" value="{{ \App\Common\Database\Definition\AvailableStatus::getName($clientUser->is_available) }}" readonly>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="text" class="form-control" value="{{ $clientUser->email }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tel</label>
                    <input type="text" class="form-control" value="{{ $clientUser->getTel() }}" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Agency</label>
                <input type="text" class="form-control" value="{{ $clientUser->agency_name }}" readonly>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.client-user.index') }}" class="btn btn-outline-secondary">Back to list</a>
        <div class="d-flex justify-content-start text-center">
            <div class="mx-1">
                <a href="{{ route('admin.client-user.edit', $clientUser->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
            </div>
            <div>
                <form method="POST" name="delete_form" action="{{ route('admin.client-user.destroy', $clientUser->id) }}" onClick="delete_client_user('{{ $clientUser->id }}', '{{ $clientUser->getName() }}'); return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script>
        function delete_client_user(id, name) {
            // 確認ダイアログ用テキスト
            var confirm_txt = '';
            confirm_txt  = 'Bạn có chắc chắn muốn xoá thông tin nhân viên đại lý dưới không?\n\n';
            confirm_txt += id + ' : ' + name;
            // 論理削除処理
            if(confirm(confirm_txt)) {
                document.delete_form.submit();
            }
        }
    </script>
@stop
