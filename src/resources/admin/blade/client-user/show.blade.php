@extends('main')

@php $clientUser = Renderer::get('clientUser') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Thông tin nhân viên {{ $clientUser->id }}
        </h3>
    </div>
    <div class="card detail-page">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Ảnh đại diện</label>
                <div><img src="{{ $clientUser->getAvatar() }}" alt="clientUserAvatar"></div>
                
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tên nhân viên</label>
                    <div class="form-control">{{ $clientUser->getName() }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Khu vực</label>
                    <div class="form-control">{{ $clientUser->region_code }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Số điện thoại</label>
                    <div class="form-control">{{ $clientUser->getTel() }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Hotline</label>
                    <div class="form-control">{{ $clientUser->getHotline() }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Trạng thái</label>
                    <div class="form-control">{{ \App\Common\ClientUser\Definition\ClientStatus::getName($clientUser->status) }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <div class="form-control">{{ $clientUser->email }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Đại lý</label>
                    <div class="form-control"><a href="{{ route('admin.agency.show', $clientUser->agency_id) }}" class="text-link">{{ $clientUser->agency_name }}</a></div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Ngày tạo mới
                    </label>
                    <div class="form-control">{{ $clientUser->getCreatedAt() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.client-user.index') }}" class="btn btn-outline-secondary">Quay lại</a>
        <div class="d-flex justify-content-start text-center">
            <div class="mx-1">
                <a href="{{ route('admin.client-user.edit', $clientUser->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Chỉnh sửa</a>
            </div>
            <div>
                <form method="POST" name="delete_form" action="{{ route('admin.client-user.destroy', $clientUser->id) }}" onClick="delete_client_user('{{ $clientUser->id }}', '{{ $clientUser->getName() }}'); return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Xoá</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/js/client.js', 'admin') }}"></script>
@stop
