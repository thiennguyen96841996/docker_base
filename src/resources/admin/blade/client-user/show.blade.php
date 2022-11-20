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
    <div class="card detail-page">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Avatar</label>
                <div><img src="{{ $clientUser->getAvatar() }}" alt="clientUserAvatar"></div>
                
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Name</label>
                    <div class="form-control">{{ $clientUser->getName() }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Region</label>
                    <div class="form-control">{{ $clientUser->region_code }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tel</label>
                    <div class="form-control">{{ $clientUser->getTel() }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Hotline</label>
                    <div class="form-control">{{ $clientUser->getHotline() }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Status</label>
                    <div class="form-control">{{ \App\Common\ClientUser\Definition\ClientStatus::getName($clientUser->status) }}</div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <div class="form-control">{{ $clientUser->email }}</div>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Agency</label>
                    <div class="form-control"><a href="{{ route('admin.agency.show', $clientUser->agency_id) }}" class="text-link">{{ $clientUser->agency_name }}</a></div>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Created At</label>
                    <div class="form-control">{{ $clientUser->getCreatedAt() }}</div>
                </div>
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
    <script type="application/javascript" src="{{ busting('/js/client.js', 'admin') }}"></script>
@stop
