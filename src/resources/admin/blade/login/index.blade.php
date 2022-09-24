@extends ('main')

@section('CONTENTS')
    <form action="{{ route('admin.login.login') }}" method="post" enctype="application/x-www-form-urlencoded">
        @csrf
        メールアドレス<input type="text" name="email" value="">
        パスワード<input type="password" name="password" value="">
        <input type="submit" value="ログイン">
    </form>
@stop
