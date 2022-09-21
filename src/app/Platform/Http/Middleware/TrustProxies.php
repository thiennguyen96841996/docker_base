<?php

namespace GLC\Platform\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    //TODO:拡張方法これでOKかあとで確認
    protected $proxies = '**';
}