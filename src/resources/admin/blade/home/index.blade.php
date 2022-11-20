@extends ('main')

@section('title', Renderer::getPageTitle())

@section('MSG')
    @include('include.msg.status-msg')
@stop

@section('page-heading')
    Trang tổng quan
@stop

@section('CONTENTS')
    <div class="card">
        <div class="card-body">
            <p>Nội dung</p>
        </div>
    </div>
@stop
