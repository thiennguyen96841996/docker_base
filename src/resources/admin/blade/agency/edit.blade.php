@extends('main')

@php
    $agency = Renderer::get('agency');
@endphp

@section('CONTENTS')
    @include('include.msg.error-msg')
    <div class="page-title">
        <h3>
            Agency Edit
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.agency.updateConfirm', ['agency' => $agency->id]) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $agency->id }}">
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Agency Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" value="{{ Renderer::oldOrElse('name', $agency) }}" required>
                            </div>
                        </div>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Tel</label>
                            <div class="col-sm-10">
                                <input type="text" name="tel" class="form-control" value="{{ Renderer::oldOrElse('tel', $agency) }}" required>
                            </div>
                        </div>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Address</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" value="{{ Renderer::oldOrElse('address', $agency) }}" class="form-control" required>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"  value="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <h3>Agency edit</h3>
    <form method="post" action="{{ route('admin.agency.updateConfirm', ['agency' => $agency->id]) }}">
        @csrf
        <label>ID</label>{{ $agency->id }}
        <input type="hidden" name="id" value="{{ $agency->id }}">
        <label>Name:</label><input type="text" name="name" value="{{ Renderer::oldOrElse('name', $agency) }}">
        <label>Tel:</label><input type="text" name="tel" value="{{ Renderer::oldOrElse('tel', $agency) }}">
        <label>Address:</label><input type="text" name="address" value="{{ Renderer::oldOrElse('address', $agency) }}">
        <input type="submit" value="submit">
    </form> -->
@stop
