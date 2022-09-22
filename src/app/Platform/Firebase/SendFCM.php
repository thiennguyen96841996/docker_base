<?php
namespace GLC\Platform\Firebase;

use Illuminate\Support\Facades\Log;
use GLC\Platform\Firebase\Definitions\FcmActionConstants;

/**
 * firebase message送信処理
 *
 */
class SendFCM
{
    /**
     * @param array $deviceTokenList カスタマID
     * @param String $title プッシュ通知のタイトル
     * @param String $content プッシュ通知の内容
     * @param String $click_action プッシュ通知のクリック後の移動画面 ("mypage", "confirm_list")
     * @param String|null $entryId
     * @return bool
     */
    public function sendRequestFCM(array $deviceTokenList, String $title, String $content, String $click_action, String $entryId = null): bool
    {
        if (empty($deviceTokenList) || empty($title)){
            return false;
        }

        $pushData = array("registration_ids" => $deviceTokenList, "notification" => array( "title" => $title, "body" => $content, "sound"=>"default"), "content_available" => true);
        if (!empty($click_action)){
            $pushData['data'] = array("click_action" => $click_action,);
        }
        if ($click_action = FcmActionConstants::FCM_ACTION_PAYSLIP){
            $pushData['data'] = array_merge($pushData['data'], array("entry_id" => $entryId));
        }
        $pushDataString = json_encode($pushData);

        $fcmAPIKey = env('FCM_API_KEY');

        $headers = array
        (
            'Authorization: key=' . $fcmAPIKey,
            'Content-Type: application/json'
        );

        $ch = curl_init();

        curl_setopt($ch ,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pushDataString);

        $result = curl_exec($ch);

        // noticeへ出力を検討
        Log::channel('basic')->notice($result);

        curl_close ($ch);

        return $result;
    }

}