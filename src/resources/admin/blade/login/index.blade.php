@extends ('main')

@section('title', Renderer::getPageTitle())

@section('CSS')
    <link href="{{ busting('/css/login.css', 'admin') }}" rel="stylesheet">
@stop

@section('LOGIN-PAGE-CONTENTS')
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class="brand" style="max-width: 100px;" src="{{ busting('img/logo.png', 'admin') }}" alt="bootstraper logo">
                    </div>
                    <h6 class="mb-4 text-muted">Đăng nhập với tài khoản của bạn</h6>
                    @if(!empty($errors->getMessages()))
                        <div class="text text-danger">
                            @foreach(Arr::collapse($errors->getMessages()) as $msg)
                                <p class="">{{ $msg }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{ route('admin.login.login') }}" method="post" enctype="application/x-www-form-urlencoded">
                        @csrf
                        <div class="mb-3 text-start {!! !$errors->has('email') ?: 'text text-danger' !!}">
                            <label for="email" class="form-label">Email</label>
                            <input name ="email" type="email" class="form-control {!! !$errors->has('email') ?: 'is-invalid' !!}" placeholder="Nhập Email">
                        </div>
                        <div class="mb-3 text-start {!! !$errors->has('password') ?: 'text text-danger' !!}">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input name="password" type="password" class="form-control {!! !$errors->has('password') ?: 'is-invalid' !!}" placeholder="Nhập mật khẩu">
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4">Đăng nhập</button>
                    </form>
                    <p class="mb-2 text-muted">Quên mật khẩu? <a href="forgot-password.html">Cài lại mật khẩu</a></p>
                    <p class="mb-0 text-muted">Bạn chưa có tài khoản? <a href="signup.html">Đăng ký</a></p>
                </div>
            </div>
        </div>
    </div>
@stop
