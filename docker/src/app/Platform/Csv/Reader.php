<?php
namespace GLC\Platform\Csv;

use Illuminate\Support\Arr;
use SplFileObject;
use GLC\Platform\Csv\Contracts\CsvProcessor as CsvProcessorContract;
use GLC\Platform\Csv\Exceptions\ConvertEncodingException;
use GLC\Platform\Csv\Exceptions\ProcessFailedException;

/**
 * CSVデータを読み込むためのクラス。
 *
 * @package GLC\Platform\Csv
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class Reader
{
    /**
     * 行番号: ヘッダー行
     * @int
     */
    const LINE_NUMBER_HEADER = 1;

    /**
     * CsvProcessorを実装したオブジェクト
     * @var CsvProcessorContract
     */
    protected CsvProcessorContract $processor;

    /**
     * ヘッダー行のデータ配列
     * @var array
     */
    protected array $headerData = [];

    /**
     * 処理を終えたCSVのデータ配列
     * @var array
     */
    protected array $records = [];

    /**
     * エンコーディングの変換に失敗したデータ配列。
     * @var array
     */
    protected array $FailedToConvertRows = [];

    /**
     * エンコーディングの変換に失敗したデータ配列。
     * @var array
     */
    protected array $FailedToProcessRows = [];

    /**
     * CSVを読み込む。
     *
     * @param  string $filePath
     * @return void
     */
    public function read(string $filePath)
    {
        if (!file_exists($filePath)) {
            return;
        }

        $file = new SplFileObject($filePath);
        $file->setFlags(SplFileObject::READ_CSV);

        foreach ($file as $i => $data) {
            /*
             * 最後の行に空っぽがあった場合は無視する。
             * ex)
             * array (
             *    [0] =>
             * )
             */
            if ($file->eof() && count($data) === 1 && empty($data[0])) {
                continue;
            }

            $lineNumber = $i + 1;
            try {
                if ($lineNumber === self::LINE_NUMBER_HEADER) {
                    $this->headerData = $this->convertEncodingIfNeed($data);
                    continue;
                }

                if (count($data) === count($this->headerData)) {
                    $converted = [];
                    foreach (array_combine($this->headerData, $this->convertEncodingIfNeed($data)) as $key => $value) {
                        Arr::set($converted, $key, convertCrlf($value));
                    }
                    if (!is_null($this->processor)) {
                        $converted = $this->processor->run($converted);
                    }
                    $this->records[$lineNumber] = $converted;
                } else {
                    $this->FailedToConvertRows[$lineNumber] = $data;
                }
            } catch (ConvertEncodingException $cee) {
                // 変換に失敗したデータを保持して次の行へ
                $this->FailedToConvertRows[$lineNumber] = $data;
            } catch (ProcessFailedException $pfe) {
                // プロセッサーの実行に失敗したデータを保持して次の行へ
                $this->FailedToProcessRows[$lineNumber] = $data;
            }
        }
    }

    /**
     * ヘッダー行のデータ配列を取得する。
     *
     * @return array
     */
    public function getHeaderData(): array
    {
        return $this->headerData;
    }

    /**
     * 処理を終えたCSVのデータ配列を取得する。
     *
     * @return array
     */
    public function getRecords(): array
    {
        return $this->records;
    }

    /**
     * プロセッサーを設定する。
     *
     * @param CsvProcessorContract $processor CsvProcessorを実装したオブジェクト
     */
    public function setProcessor(CsvProcessorContract $processor)
    {
        $this->processor = $processor;
    }

    /**
     * 与えられたデータのエンコーディングを変換する。
     *
     * @param  array $data 変換したいデータ
     * @return array
     * @throws ConvertEncodingException
     */
    protected function convertEncodingIfNeed(array $data): array
    {
        // UTF-8ではない場合(=sjis-win/windows製のエクセルCSV)のデータは変換する
        if (!mb_check_encoding(implode(',', $data), 'UTF-8')) {
            // TODO sjis-win決め打ちで大丈夫か？
            if (!mb_convert_variables('UTF-8', 'SJIS-win', $data)) {
                // 失敗した場合は例外を投げてその行は飛ばす
                throw new ConvertEncodingException();
            }
        }
        return $data;
    }
}