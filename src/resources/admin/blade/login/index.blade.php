@extends ('main')

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
                    <h6 class="mb-4 text-muted">Login to your account</h6>
                    <form action="{{ route('admin.login.login') }}" method="post" enctype="application/x-www-form-urlencoded">
                        @csrf
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email adress</label>
                            <input name ="email" type="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button class="btn btn-primary shadow-2 mb-4">Login</button>
                    </form>
                    <p class="mb-2 text-muted">Forgot password? <a href="forgot-password.html">Reset</a></p>
                    <p class="mb-0 text-muted">Don't have account yet? <a href="signup.html">Signup</a></p>
                </div>
            </div>
        </div>
    </div>
@stop
