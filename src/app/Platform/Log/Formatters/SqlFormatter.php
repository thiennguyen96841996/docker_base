<?php
namespace GLC\Platform\Log\Formatters;

/**
 * アプリケーションから出力されるSQLログのフォーマットを設定するクラス。
 *
 * @package GLC\Platform\Log\Formatter
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class SqlFormatter extends BasicFormatter
{
    /**
     * 出力するログ情報(全体)のフォーマットを返す。
     *
     * @return string
     */
    protected function getLogFormat(): string
    {
        return '[%datetime%] %message% %context%' . PHP_EOL;
    }
}