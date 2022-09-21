<?php

namespace GLC\Platform\Csv;
use SplFileObject;

class CsvUpload implements \IteratorAggregate
{

    const FILE_TYPE_CSV = '01';
    const FILE_TYPE_TSV = '02';

    private $startLinePos = 0;

    private $strFileType = self::FILE_TYPE_CSV;

    private $fileResource;

    private $aryCsvHeader = [];
    private $aryOrgCsvHeader = [];

    private $convertObj;

    private $iterator;

    /**
     * CSV constructor.
     * @param bool $strFileName
     * @param array $aryCsvHeader
     * @param bool $header
     * @throws \Exception
     */
    public function __construct($strFileName = false, array $aryCsvHeader = [], $header = true)
    {
        if($strFileName !== false){
            $this->setFileResource($strFileName);
            $this->setCsvHeader($aryCsvHeader, $header);
        }
        return $this;
    }

    /**
     * @param $strFileName
     * @return mixed
     * @throws \Exception
     */
    public function getFirstRecord($strFileName): mixed
    {
        $this->setFileResource($strFileName);
        return $this->fileResource->fgetcsv();
    }

    /**
     * setFileResource
     *
     * @param string $strFileName
     * @throws \Exception
     */
    public function setFileResource($strFileName)
    {
        if(file_exists($strFileName)){
            // ファイル開く
            $csvFile = fopen($strFileName, 'r');

            $temp = tmpfile();
            $meta = stream_get_meta_data($temp);
            static $first = true;
            while (!feof($csvFile)) {
                $strLineData = fgets($csvFile);
                if($first){
                    // BOMあれば削除
                    $strLineData = preg_replace('/^\xEF\xBB\xBF/','', $strLineData);
                    $first = false;
                }
                $strLineDataToUTF8 = mb_convert_encoding($strLineData, 'UTF-8', mb_detect_encoding($strLineData, "utf-8, eucjp-win, sjis-win "));
                fwrite($temp, $strLineDataToUTF8);
            }
            rewind($temp);
            $this->fileResource = New SplFileObject($meta['uri'], 'r');


            $this->fileResource->setFlags(SplFileObject::READ_CSV);
        }else{
            throw New \Exception('ファイルがありません。');
        }
    }

    public function getCsvHeader()
    {
        return $this->aryCsvHeader;
    }

    /**
     * setCsvHeader
     *
     * @param array $aryCsvHeader
     * @param bool $header
     */
    public function setCsvHeader(array $aryCsvHeader = [], $header = true)
    {
        //CSVのヘッダーと指定項目のマッピング
        if($header){
            if($this->strFileType === self::FILE_TYPE_TSV){
                $this->aryCsvHeader = $this->getCsvMappingHeader($this->fileResource->fgetcsv("\t"), $aryCsvHeader, $header);
            }else{
                $this->aryCsvHeader = $this->getCsvMappingHeader($this->fileResource->fgetcsv(), $aryCsvHeader, $header);
            }
        }else{
            $this->aryCsvHeader = $this->getCsvMappingHeader([], $aryCsvHeader, $header);
        }
        $this->startLinePos = $this->fileResource->ftell();
    }


    /**
     * getIterator
     *
     * @return \Generator
     */
    public function getIterator()
    {
        while(!$this->fileResource->eof()){
            //終端の空行を除く処理　空行の場合に取れる値は後述
            if($this->strFileType === self::FILE_TYPE_TSV){
                $csvLine = $this->fileResource->fgetcsv("\t");
            }else {
                $csvLine = $this->fileResource->fgetcsv();
            }
            $aryTmp = [];
            foreach($this->aryCsvHeader as $key => $csvKey){
                if($csvKey !== false){
                    if(array_key_exists($csvKey, $csvLine)){
                        $aryTmp[$key] = $csvLine[$csvKey];
                    }
                }else{
                    $aryTmp[$key] = null;
                }
            }
            if(is_null($this->convertObj)){
                yield $aryTmp;
            }else{
                $convertObj = $this->convertObj;
                // yield $convertObj($aryTmp, array_combine($this->aryOrgCsvHeader, $csvLine));
                yield $convertObj($aryTmp);
            }
        }
        //複数回呼ばれてもいいように対応
        $this->fileResource->fseek($this->startLinePos);
    }

    /**
     * CSVの項目と指定ヘッダーを見て対象の項目を設定する
     *
     * @param $aryCsvHeader
     * @param $aryTargetHeader
     * @param bool $header
     * @return array
     */
    private function getCsvMappingHeader($aryCsvHeader, $aryTargetHeader, $header = true)
    {
        $aryResult = [];
        if($header){
            $csvKey = 0;
            foreach($aryTargetHeader as $key => $value){
                $aryResult[$key] = $csvKey;
                $csvKey++;
            }
            $this->aryOrgCsvHeader = $aryCsvHeader;
        }else{
            $aryResult = $aryTargetHeader;
            $this->aryOrgCsvHeader = $aryTargetHeader;
        }
        return $aryResult;
    }

    public function convertData(\Closure $obj)
    {
        $this->convertObj = $obj;
        return $this;
    }

    public function toArray()
    {
        return iterator_to_array($this, true);
    }
}
