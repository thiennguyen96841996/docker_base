@extends('main')

@php 
    $agencies = Renderer::get('agencies');
    $clientUser = Renderer::get('clientUser');
@endphp

@section('title', Renderer::getPageTitle())

@section('CONTENTS')
    @include('include.msg.error-msg')

    <div class="page-title">
        <h3>
            Client Create
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.client-user.createConfirm') }}" class="common-form">
                        @csrf
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label fw-bold required-mark">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" value="{{ Renderer::oldOrElse('name', $clientUser) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tel" class="form-label fw-bold required-mark">Tel</label>
                                <input type="text" name="tel" placeholder="0123456789" class="form-control" value="{{ Renderer::oldOrElse('tel', $clientUser) }}">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label fw-bold required-mark">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="abc@example.com" value="{{ Renderer::oldOrElse('email', $clientUser) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="status" class="form-label fw-bold required-mark">Status</label>
                                <select name="is_available" class="form-select">
                                    @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                                        @if (!empty($clientUser) && Renderer::oldOrElse('is_available', $clientUser) == $status->value)
                                            <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @else
                                            <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="agency_id" class="form-label fw-bold required-mark">Agency</label>
                            <select name="agency_id" class="form-select">
                            @foreach(Renderer::get('agencies') as $agency)
                                @if (!empty($clientUser) && Renderer::oldOrElse('agency_id', $clientUser) == $agency->id)
                                    <option value="{{$agency->id}}" selected>{{$agency->name}}</option>
                                @else
                                    <option value="{{$agency->id}}">{{$agency->name}}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end text-center mt-4">
                            <a href="{{ route('admin.client-user.index') }}" class="btn btn-outline-secondary me-2">Back to list</a>
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
