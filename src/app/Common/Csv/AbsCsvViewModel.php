<?php


namespace App\Common\Csv;

use App\Common\Csv\Contract\CsvViewModel as CsvViewModelContract;
use Illuminate\Database\Eloquent\Builder;

abstract class AbsCsvViewModel implements CsvViewModelContract
{

    private $builder;

    /**
     * クエリビルダをセット
     * setBuilder
     *
     * @param  Builder|array $builder
     * @return $this
     */
    public function setBuilder($builder)
    {
        // 配列でないときは配列に変換する
        if (!is_array($builder)) $builder = [$builder];

        $this->builder = $builder;

        return $this;
    }

    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * CSVファイルのヘッダー出力有無
     *
     * @return bool
     */
    public function getHeaderFlag(): bool
    {
        return true;
    }

    /**
     * 区切り文字取得
     *
     * @return string
     */
    public function getSeparator(): string
    {
        return ",";
    }

    /**
     * ヘッダーの囲み文字取得
     *
     * @return string
     */
    public function getHeaderEnclosure()
    {
        return '';
    }

    /**
     * ボディの囲み文字取得
     *
     * @return string
     */
    public function getEnclosure()
    {
        return '';
    }

    /**
     * 改行コード取得
     *
     * @return string
     */
    public function getNewLineCode()
    {
        return "\n";
    }
}
