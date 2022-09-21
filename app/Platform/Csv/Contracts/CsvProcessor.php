<?php
namespace GLC\Platform\Csv\Contracts;

use GLC\Platform\Csv\Exceptions\ProcessFailedException;

/**
 * CSVデータを処理するためのクラスの振る舞いを表すインターフェイス。
 *
 * @package GLC\Platform\Csv\Contracts
 * @author  TinhNC <tinhhang22@gmail.com>
 */
interface CsvProcessor
{
    /**
     * データを処理する。
     *
     * ※ 渡されるデータはCSVデータとしては正しいことが保証される。
     *   - UTF-8形式になっている
     *   - ヘッダーの項目とデータの項目数が一致している。
     *
     * ※ 問題発生時にProcessFailedExceptionを投げることでCsv\Readerクラスにてデータが保持されるので
     *    必要に応じた使用を推奨する。
     *
     * @param  array $data 処理したいデータ(ヘッダー行の項目をキーにした連想配列)
     * @return array 処理したデータ
     * @throws ProcessFailedException CsvProcessorによるプロセッサーの実行に失敗した時
     */
    public function run(array $data): array;

    /*
     * sample
     *
    public function run(array $data): array
    {
        // こんな感じで何らかの判定をかけて失敗した場合は、例外を投げる
        if (empty($data)) {
            throw new ProcessFailedException('failed.');
        }

        $data['aaa'] = $this->someConvertProcess($data);

        // 変換する配列を登録データに即したものにしても良い
        // ※この関数以降で行われる処理はないため

        $data['company']['xxx'] = $data['xxx']
        $data['company']['yyy'] = $data['yyy']
        $data['user']['zzz']    = $data['zzz']

        return $data;
    }
    */
}