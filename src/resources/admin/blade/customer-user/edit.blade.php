@extends('main')

@php
    $customerUser = Renderer::get('customerUser');
    $isBack = Renderer::get('isBack');
    $gender = $isBack ? $customerUser->gender : $customerUser->getGender();
@endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')

    <div class="page-title">
        <h3>
            Customer Edit
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.client-user.updateConfirm',  $customerUser->id) }}" class="common-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $customerUser->id }}">
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label fw-bold required-mark">Status</label>
                                <select name="status" class="form-select">
                                    @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                                        @if ($status->value === Renderer::oldOrElse('is_available', $customerUser))
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
                                <label for="name" class="form-label fw-bold">Name</label>
                                <input type="text" class="form-control" placeholder="Nguyễn Văn A" value="{{ $isBack ? $customerUser->name : $customerUser->getName() }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Gender</label>
                                <input type="text" class="form-control" value="{{ \App\Common\Database\Definition\Gender::getName($customerUser->getGender()) }}" readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label fw-bold">Email</label>
                                <input type="text" class="form-control" value="{{ $customerUser->email }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tel" class="form-label fw-bold">Tel</label>
                                <input type="text" placeholder="0123456789" class="form-control" value="{{ $isBack ? $customerUser->tel : $customerUser->getTel() }}" readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Birthday</label>
                                <input type="text" class="form-control" value="{{ $isBack ? $customerUser->birthday : $customerUser->getBirthday() }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Address</label>
                                <input type="text" class="form-control" value="{{ $customerUser->getAddress() }}" readonly>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end text-center mt-4">
                            <a href="{{ route('admin.customer-user.show', $customerUser->id) }}" class="btn btn-outline-secondary me-2">Back to show</a>
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
