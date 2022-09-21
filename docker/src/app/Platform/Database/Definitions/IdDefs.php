<?php
namespace GLC\Platform\Database\Definitions;

/**
 * IDに関連した定義を持つクラス。
 *
 * @package GLC\Platform\Database\Definitions
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class IdDefs
{
    /**
     * 担当者(ユーザー)IDのプリフィックス
     * @var string
     */
    const ID_PREFIX_USER = 'US';

    /**
     * グループIDのプリフィックス
     * @var string
     */
    const ID_PREFIX_GROUP = 'GR';

    /**
     * 法人IDのプリフィックス
     * @var string
     */
    const ID_PREFIX_CORPORATION = 'CO';

    /**
     * 事業所IDのプリフィックス
     * @var string
     */
    const ID_PREFIX_SHOP = 'SH';

    /**
     * 応募IDのプリフィックス
     * @var string
     */
    const ID_PREFIX_ENTRY = 'EN';

    /**
     * カスタマーIDのプリフィックス
     * @var string
     */
    const ID_PREFIX_CUSTOMER = 'CU';

    /**
     * 媒体ワークIDのプリフィックス
     * @var string
     */
    const ID_PREFIX_MEDIA_WORK = 'MW';
}