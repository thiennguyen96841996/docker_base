<?php
use Illuminate\Http\Request;

return [
    /*
     * このアプリケーションで信頼するプロキシーのIPの定義。
     */
    'proxies' => [
//        '0.0.0.0/16', // DEV
//        '0.0.0.0/16', // STG
//        '0.0.0.0/16', // PROD
        '*'
    ],

    /*
     * プロキシーを検出するためのヘッダー情報の定義。
     *
     * ※AWSのELBを使う場合は『Request::HEADER_X_FORWARDED_AWS_ELB』を使う。
     *   詳しくは https://symfony.com/doc/current/deployment/proxies.html を参照のこと。
     */
    'headers' => Request::HEADER_X_FORWARDED_AWS_ELB
];