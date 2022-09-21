<?php
namespace GLC\Platform\Bootstrap\Definitions;

/**
 * 起動処理に関連する定数クラス。
 *
 * @package GLC\Platform\Bootstrap\Definitions
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class BootstrapDefs
{
    /**
     * 起動タイプ: マスター
     * @var string
     */
    const BOOT_TYPE_MASTER = 'Master';

    /**
     * 起動タイプ: マスター
     * @var string
     */
    const BOOT_TYPE_CUSTOMER = 'Customer';

    /**
     * 起動タイプ: クライアント
     * @var string
     */
    const BOOT_TYPE_CLIENT = 'Client';

    /**
     * 起動タイプ: API
     * @var string
     */
    const BOOT_TYPE_API = 'Api';

    /**
     * 起動タイプ: Secure API
     * @var string
     */
    const BOOT_TYPE_SECURE_API = 'SecureApi';

    /**
     * 起動タイプ: バッチ
     * @var string
     */
    const BOOT_TYPE_BATCH = 'Batch';
}