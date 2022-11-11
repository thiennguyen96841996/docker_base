@extends('main')

@php $post = Renderer::get('post') @endphp

@section('title', Renderer::getPageTitle())

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
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.post.updateConfirm', ['post' => $post->id]) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" value="{{ Renderer::oldOrElse('title', $post) }}" required>
                            </div>
                        </div>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Status</label>
                            <div class="col-sm-10">
                                <input type="text" name="status" class="form-control" value="{{ Renderer::oldOrElse('status', $post) }}" required>
                            </div>
                        </div>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Content</label>
                            <div class="col-sm-10">
                                <input type="text" name="content" value="{{ Renderer::oldOrElse('content', $post) }}" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">City</label>
                            <div class="col-sm-10">
                                <input type="text" name="city" value="{{ Renderer::oldOrElse('city', $post) }}" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">District</label>
                            <div class="col-sm-10">
                                <input type="text" name="district" value="{{ Renderer::oldOrElse('district', $post) }}" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Address</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" value="{{ Renderer::oldOrElse('address', $post) }}" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Price</label>
                            <div class="col-sm-10">
                                <input type="number" name="price" value="{{ Renderer::oldOrElse('price', $post) }}" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Area</label>
                            <div class="col-sm-10">
                                <input type="text" name="area" value="{{ Renderer::oldOrElse('area', $post) }}" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <input type="hidden" name="client_id" value="{{ $post->client_id }}">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" value="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
