<?php
namespace GLC\Platform\Sms;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use GLC\Platform\Sms\Definitions\SmsDefs;

/**
 * SMSを送信するクラス。
 *
 * @package GLC\Platform\Sms
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Sender
{
    /**
     * SMS LinkのAPIを使用してSMSを送信する。
     *
     * @param  array $message 送信するメッセージデータの配列
     * @return bool
     */
    public function sendSmsLink(array $message): bool
    {
        try {
            $headers = [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'token'        => env('SMS_LINK_TOKEN', 'cf3aedf8-ec02-4c6e-9847-fe8a91610ff6'), //デフォルトはサンドボックス用のトークン
            ];

            $client = new Client([
                'headers' => $headers,
                'base_uri' => env('SMS_LINK_API_URL', 'https://sand-api-smslink.nexlink2.jp'), //デフォルトはサンドボックスのURL
            ]);

            $response = $client->post(SmsDefs::SMS_LINK_API_PATH_DELIVERY, [
                'json' => $message
            ]);

            if ($response->getStatusCode() == 200) {
                return true;
            }
        } catch (ClientException|GuzzleException $e) {
            unset($message['contacts']); // 電話番号はログに出力しない
            Log::channel('error')->error('SMS送信に失敗しました。');
            Log::channel('error')->error((string) $e->getResponse()->getBody(), $message);
        } catch (Exception $e) {
            unset($message['contacts']); // 電話番号はログに出力しない
            Log::channel('error')->error('SMS送信に失敗しました。');
            Log::channel('error')->error($e, $message);
        }
        return false;
    }

    /**
     * SMS LinkのAPIに送信するメッセージを作成する。
     *
     * @param string $tel 送信対象の電話番号
     * @param string $message 送信したいメッセージ
     * @param bool $isCountClick クリックをカウントするかどうか
     * @return array
     */
    public function buildMessageForSmsLink(string $tel, string $message, bool $isCountClick = false): array
    {
        return [
            'delivery_name' => 'コノヒニ',
            'contacts' => [
                [ "phone_number" => $tel, ],
            ],
            'click_count'  => $isCountClick,
            'text_message' => $message,
        ];
    }
}