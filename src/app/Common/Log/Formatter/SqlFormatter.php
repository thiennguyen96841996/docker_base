<?php
namespace App\Common\Log\Formatter;

/**
 * SQLログのフォーマットを設定するクラス。
 * @package \App\Common\Log
 */
class SqlFormatter extends BasicFormatter
{
    /**
     * 出力するログ情報(全体)のフォーマットを取得する。
     * @return string
     */
    protected function getLogFormat(): string
    {
        $format = [
            'Date:%datetime%',
            'Uid:%extra.uid%',
            'Query:%message%',
        ];
        return join("\t", $format) . PHP_EOL;
    }
}
