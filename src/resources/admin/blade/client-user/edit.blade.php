@extends('main')

@php 
    $clientUser = Renderer::get('clientUser');
    $isBack = Renderer::get('isBack');
@endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')
    <div class="page-title">
        <h3>
            Client Edit
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.client-user.updateConfirm',  $clientUser->id) }}" class="common-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $clientUser->id }}">
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label fw-bold required-mark">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" value="{{ $isBack ? $clientUser->name : $clientUser->getName() }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tel" class="form-label fw-bold required-mark">Tel</label>
                                <input type="text" name="tel" placeholder="0123456789" class="form-control" value="{{ $isBack ? $clientUser->tel : $clientUser->getTel() }}">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label fw-bold required-mark">Status</label>
                                <select name="is_available" class="form-select">
                                    @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                                        @if ($status->value === Renderer::oldOrElse('is_available', $clientUser))
                                            <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @else
                                            <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="line my-3"></div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label fw-bold required-mark">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ $clientUser->email }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <input type="hidden" name="agency_id" value="{{ $clientUser->agency_id }}">
                                <label for="tel" class="form-label fw-bold required-mark">Agency</label>
                                <input type="text" name="agency_name" placeholder="0123456789" class="form-control" value="{{ $clientUser->agency_name }}" readonly>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end text-center mt-4">
                            <a href="{{ route('admin.client-user.show', $clientUser->id) }}" class="btn btn-outline-secondary me-2">Back to show</a>
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
