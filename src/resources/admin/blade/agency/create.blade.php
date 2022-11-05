@extends('main')

@php $agency = Renderer::get('agency') @endphp

@section('CONTENTS')
    @include('include.msg.error-msg')
    <div class="page-title">
        <h3>
            Agency Create
        </h3>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form method="POST" action="{{ route('admin.agency.createConfirm') }}">
                        @csrf
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Agency Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder="Nguyễn Văn A" required value="{{ Renderer::oldOrElse('name', $agency) }}">
                            </div>
                        </div>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Tel</label>
                            <div class="col-sm-10">
                                <input type="text" name="tel" placeholder="0123456789" class="form-control" required value="{{ Renderer::oldOrElse('tel', $agency) }}">
                            </div>
                        </div>
                        <div class="line"></div><br>
                        <div class="mb-3 row">
                            <label class="col-sm-2 fw-bold">Address</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" placeholder="Số 1 Đ. Trần Duy Hưng, Trung Hoà, Quận Cầu Giấy, TP Hà Nội" class="form-control" required value="{{ Renderer::oldOrElse('address', $agency) }}">
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" value="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
