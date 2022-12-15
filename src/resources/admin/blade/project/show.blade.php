@extends('main')

@php $project = Renderer::get('project') @endphp

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.status-msg')
@stop

@section('page-heading')
    Dự án {{ $project->id }}
@stop

@section('CONTENTS')
    <div class="card detail-page">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Ảnh đại diện</label>
                <div><img src="{{ $project->avatar != null ? \App\Common\AWS\S3Service::display(\App\Common\Project\Definition\ProjectAvatar::PROJECT_AVATAR_FOLDER, $project->id . '/' . \Carbon\Carbon::now()->format('Y') . '_' . \Carbon\Carbon::now()->format('m') . '/' . \App\Common\Project\Definition\ProjectAvatar::PROJECT_IMAGE_FOLDER . '/' . $project->avatar) : asset(\App\Common\Project\Definition\ProjectAvatar::CLIENT_PROJECT_DEFAULT_AVATAR) }}" alt="Ảnh đại diện dự án"></div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Tiêu đề</label>
                <div class="form-control">{{ $project->title }}</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Slug</label>
                <div class="form-control">{{ $project->slug }}</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Mô tả</label>
                <textarea class="form-control" rows="10" readonly>{{ $project->description }}</textarea>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tỉnh/Thành phố</label>
                    <div class="form-control">{{ $project->city_name }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Quận/Huyện</label>
                    <div class="form-control">{{ $project->district_name }}</div>
                </div>
            </div>
            <div class="mb-3">
                    <label class="form-label fw-bold">Địa chỉ</label>
                    <div class="form-control">{{ $project->address }}</div>
                </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Giá (VNĐ)</label>
                    <div class="form-control">{{ number_format($project->price) }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Diện tích (m2)</label>
                    <div class="form-control">{{ $project->area }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Loại hình dự án</label>
                    <div class="form-control">{{ $project->project_category_name }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tình trạng</label>
                    <div class="form-control">{{ \App\Common\Project\Definition\ProjectStatus::getName($project->status) }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">ID Client</label>
                    <div class="form-control"><a href="{{ route('admin.client-user.show', $project->client_id) }}" class="text-link">{{ $project->client_id }}</a></div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tên Client</label>
                    <div class="form-control">{{ $project->getClientName() }}</div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.project.index') }}" class="btn btn-outline-secondary">Quay lại</a>
@stop
