@component('mail::message')
# あなたのアカウントがログインされました

@component('mail::panel')
■ ログイン日時<br>
__{{ $date }}__

■ IPアドレス<br>
__{{ $ip }}__
@endcomponent

@component('mail::button', [ 'url' => $url ])
    ログイン履歴を確認する
@endcomponent

このメールはシステムから自動で送信されています。<br>
{{ config('app.name') }}
@endcomponent
