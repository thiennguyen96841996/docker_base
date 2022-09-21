<?php

namespace GLC\Batch\Console\Commands;

use Illuminate\Foundation\Console\DownCommand as DownCommand;

/**
 * メンテナンスを起動するバッチ。
 *
 * @var string
 */

class DownService extends DownCommand
{

    /**
     * DownService constructor.
     */
    public function __construct()
    {
        $signature = $this->signature;
        $signature .= "\n" . '{--message= : メンテナンスのメッセージ}';
        $signature .= "\n" . '{--allow=* : メンテナンス中でもアクセス可能なIPまたはネットワーク}';
        $this->signature = $signature;

        parent::__construct();
    }


    /**
     * downファイルから、ペイロードを取得する
     *
     * @return array
     */
    protected function getDownFilePayload()
    {
        $return = parent::getDownFilePayload();

        return array_merge($return, [
            'message' => $this->option('message'),
            'allowed' => $this->option('allow'),
        ]);
    }
}
