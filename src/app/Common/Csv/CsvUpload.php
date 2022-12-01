<?php

namespace App\Common\Csv;

use SplFileObject;

class CsvUpload implements \IteratorAggregate
{
    /**
     * @var int
     */
    private int $startLinePos = 0;

    /**
     * @var SplFileObject
     */
    private SplFileObject $fileResource;

    /**
     * @var array
     */
    private array $aryCsvHeader = [];

    /**
     * @var array
     */
    private array $aryOrgCsvHeader = [];

    /**
     * @var
     */
    private $convertObj;

    /**
     * CSV constructor.
     * @param bool $strFileName
     * @param array $aryCsvHeader
     * @param bool $header
     * @throws \Exception
     */
    public function __construct(bool $strFileName = false, array $aryCsvHeader = [], bool $header = true)
    {
        if($strFileName !== false){
            $this->setFileResource($strFileName);
            $this->setCsvHeader($aryCsvHeader, $header);
        }
        return $this;
    }

    /**
     * setFileResource
     *
     * @param string $strFileName
     * @throws \Exception
     */
    public function setFileResource(string $strFileName)
    {
        if(file_exists($strFileName)){
            // open file
            $csvFile = fopen($strFileName, 'r');
            $temp = tmpfile();
            $meta = stream_get_meta_data($temp);
            static $first = true;
            while (!feof($csvFile)) {
                $strLineData = fgets($csvFile);
                if($first){
                    // Delete if BOM
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
            throw New \Exception('no file exist。');
        }
    }

    /**
     * setCsvHeader
     *
     * @param array $aryCsvHeader
     * @param bool $header
     */
    public function setCsvHeader(array $aryCsvHeader = [], bool $header = true)
    {
        // Mapping between CSV headers and specified items
        if($header){
            $this->aryCsvHeader = $this->getCsvMappingHeader($this->fileResource->fgetcsv(), $aryCsvHeader, $header);
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
    public function getIterator(): \Generator
    {
        while(!$this->fileResource->eof()){
            // Processing to remove blank lines at the end.The values that can be taken in the case of blank lines are described later.
            $csvLine = $this->fileResource->fgetcsv();
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
                yield $convertObj($aryTmp);
            }
        }
        // Support so that it can be called multiple times
        $this->fileResource->fseek($this->startLinePos);
    }

    /**
     * Set target items by looking at CSV items and specified headers
     *
     * @param $aryCsvHeader
     * @param $aryTargetHeader
     * @param bool $header
     * @return array
     */
    private function getCsvMappingHeader($aryCsvHeader, $aryTargetHeader, bool $header = true): array
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


    /**
     * @return array
     */
    public function toArray(): array
    {
        return iterator_to_array($this, true);
    }
}
