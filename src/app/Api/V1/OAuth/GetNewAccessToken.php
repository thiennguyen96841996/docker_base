<?php
namespace GLC\Api\V1\OAuth;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ServerRequestInterface;

/**
 * refresh_tokenで、新しいアクセストークンを申請する
 */
class GetNewAccessToken extends BaseController
{
    /**
     * APIを実行する。
     *
     * @param ServerRequestInterface $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute(ServerRequestInterface $request): JsonResponse
    {
        try {
            $newToken = app('Laravel\Passport\Http\Controllers\AccessTokenController')->issueToken($request);

            return response()->json([ 'token' =>$newToken->content()], 200);

        }catch (\Throwable $thw) {
            Log::channel('error')->error($thw->getMessage());

            return response()->json([ 'message' => $thw->getMessage() ], 401);
        }

    }
}