@extends('main')

@php $post = Renderer::get('post') @endphp

@section('title', Renderer::getPageTitle())

@section('CSS')
    <link href="{{ busting('/vendor/airdatepicker/datepicker.min.css', 'admin') }}" rel="stylesheet">
@stop

@section('CONTENTS')
    @include('include.msg.error-msg')

    <div class="page-title">
        <h3>
            Post Edit
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.post.updateConfirm', ['post' => $post->id]) }}" class="common-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <div class="mb-3">
                            <label class="form-label fw-bold required-mark">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ Renderer::oldOrElse('title', $post) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold required-mark">Content</label>
                            <textarea name="content" class="form-control" rows="10">{{ Renderer::oldOrElse('content', $post) }}</textarea>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold required-mark">City</label>
                                <input type="text" name="city" value="{{ Renderer::oldOrElse('city', $post) }}" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold required-mark">District</label>
                                <input type="text" name="district" value="{{ Renderer::oldOrElse('district', $post) }}" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold required-mark">Address</label>
                            <input type="text" name="address" value="{{ Renderer::oldOrElse('address', $post) }}" class="form-control">
                            <small class="form-text text-muted">Ghi địa chỉ từ sau quận/huyện</small>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Price (VNĐ)</label>
                                <input type="number" name="price" value="{{ Renderer::oldOrElse('price', $post) }}" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Area (m2)</label>
                                <input type="number" name="area" value="{{ Renderer::oldOrElse('area', $post) }}" class="form-control">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Published At</label>
                                <input type="text" name="published_at" class="form-control datepicker-here" value="{{ Renderer::oldOrElse('published_at', $post) }}" autocomplete="off">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Closed At</label>
                                <input type="text" name="closed_at" class="form-control datepicker-here" value="{{ Renderer::oldOrElse('closed_at', $post) }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold required-mark">Client</label>
                                <input type="text" name="client_id" class="form-control" value="{{ Renderer::oldOrElse('client_id', $post) }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    @foreach(\App\Common\Database\Definition\AvailableStatus::cases() as $status)
                                        @if (Renderer::oldOrElse('status', $post) == $status->value)
                                            <option value="{{$status->value}}" selected>{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @else
                                            <option value="{{$status->value}}">{{\App\Common\Database\Definition\AvailableStatus::getName($status->value)}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end text-center mt-4">
                            <a href="{{ route('admin.post.show', $post->id) }}" class="btn btn-outline-secondary me-2">Back to show</a>
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section ('JAVASCRIPT')
    <script type="application/javascript" src="{{ busting('/vendor/airdatepicker/datepicker.js', 'admin') }}"></script>
@stop
