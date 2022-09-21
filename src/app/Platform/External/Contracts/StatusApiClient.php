<?php
namespace GLC\Platform\External\Contracts;

/**
 * 媒体に対してステータス更新を通知するための振る舞いを持つインターフェイス。
 *
 * @package Wanriku\Platform\External\Contracts
 */
interface StatusApiClient
{
    /**
     * APIのURLを取得する。
     *
     * @return string
     */
    public function getApiUrl(): string;

    /**
     * APIのパスを取得する。
     *
     * @return string
     */
    public function getApiPath(): string;

    /**
     * APIパラメータを設定する。
     *
     * @param ShopMediaAccount $account 媒体アカウントデータを持つオブジェクト
     * @param string $mediaEntryId 更新対象の媒体エントリーID
     * @param string $recruitmentStatus 採用ステータスコード
     */
    public function setApiParams($params);
}