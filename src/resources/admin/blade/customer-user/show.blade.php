@extends('main')

@php $customerUser = Renderer::get('customerUser') @endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.status-msg')

    <div class="page-title">
        <h3>
            Customer User {{ $customerUser->id }}
        </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getName() }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Gender</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getGender() }}" readonly>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Email</label>
                    <input type="text" class="form-control" value="{{ $customerUser->email }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Tel</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getTel() }}" readonly>
                </div>
            </div>
            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Birthday</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getBirthday() }}" readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label fw-bold">Address</label>
                    <input type="text" class="form-control" value="{{ $customerUser->getAddress() }}" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.customer-user.index') }}" class="btn btn-outline-secondary">Back to list</a>
        <div class="d-flex justify-content-start text-center">
            <div class="mx-1">
                <a href="{{ route('admin.customer-user.edit', $customerUser->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
            </div>
            <div>
                <form method="POST" name="delete_form" action="{{ route('admin.customer-user.destroy', $customerUser->id) }}" onClick="delete_client_user('{{ $customerUser->id }}', '{{ $customerUser->getName() }}'); return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                </form>
            </div>
        </div>
    </div>
@stop
