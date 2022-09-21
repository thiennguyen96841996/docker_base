<?php

namespace GLC\Platform\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Configuration;

class CheckAccessToken
{
    /**
     * @var TokenRepository
     */
    private $tokens;

    /**
     * CheckAccessToken constructor.
     * @param TokenRepository $tokens
     */
    public function __construct(TokenRepository $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * トークンが存在するかどうかを確認して、有効期限を確認する
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // oauth token チェックが無効の場合はそのまま進む
        if ($this->isDisabledOauthCheckForTemporarily($request)) {
            return $next($request);
        }

        //access tokenから、IDを取得する
        if(!empty($accessToken = Arr::get($request->header(), 'token'))) {
            try {
                $accessTokenId = Configuration::forUnsecuredSigner()->parser()->parse($accessToken[0])->claims()->get('jti');
            } catch (\Throwable $thw) {
                $accessTokenId = null;
                Log::channel('error')->error("トークンを取得できません, ERROR={$thw}");
            }

            if ($accessTokenId != null && !empty($token = $this->tokens->find($accessTokenId)) && $token['expires_at'] >= Carbon::now()) {
                return $next($request);
            } elseif (!empty($token) && $token['expires_at'] < Carbon::now())
            {
                return response()->json([ 'message' => "トークン有効期限がが切れています。" ], 401);
            } else {
                return response()->json([ 'message' => "トークンが正しくありません。" ], 401);
            }

        } else {
            Log::channel('error')->error('トークンが見つかりませんでした！');
            return response()->json([ 'message' => "トークンが見つかりませんでした！" ], 401);
        }
    }

    /**
     *
     * TODO::強制アップデートは正式に動いた後削除する
     * 前払いと本人確認提出のAPIの場合は古いアプリ(1.0.17 => 9/13リリースするバージョン)以前のものを利用している場合はoauthを無効にする
     * @param \Illuminate\Http\Request
     * @return bool
     */
    private function isDisabledOauthCheckForTemporarily(\Illuminate\Http\Request $request): bool
    {
        try {

            $oauthDisableTargetApiEndpoint = [
                'api/customer/v1/apply_prepaid',
                'api/customer/v1/apply_identification_card'
            ];

            // 前払いと本人確認提出のAPIではない場合は有効なのでfalseを返す
            if (!in_array($request->path(), $oauthDisableTargetApiEndpoint)) {
                return false;
            }

            $userInstalledVersion = $request->header('app-version');
            $minimumRequiredVersion = '1.0.17'; // 一時的なので定数化しなくて良いと思います。

            /**
             * @var Array $userInstalled
             * @var Array $minimumRequired
             */
            $userInstalled = explode('.', $userInstalledVersion);
            $minimumRequired = explode('.', $minimumRequiredVersion);

            for ($i = 0; $i < count($minimumRequired); $i++) {
                // ユーザのバージョンが大きい場合
                if (!array_key_exists($i, $userInstalled) || (int)$userInstalled[$i] > (int)$minimumRequired[$i]) {
                    return false;
                }

                // 必須バージョンが大きい場合
                if ((int)$minimumRequired[$i] > (int)$userInstalled[$i]) {
                    return true;
                }

            }

            return false;

        } catch (\Exception $e) {
            Log::channel('error')->error('トークン無効化処理にエラーが発生しました。');
            Log::channel('error')->error($e);
            /**
             * 基本的想定外のエラーが起きそうなのは
             * バージョン比較の処理の段階だと思われ、バージョン比較の段階に入ってくるというのは
             * 前払いと本人確認APIへアクセスということは保証できることなので、trueを返して、
             * トークンチェックを無理やり無効にする
             */
            return true;
        }
    }
}