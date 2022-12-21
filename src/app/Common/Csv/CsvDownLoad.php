<?php

namespace App\Common\Csv;

use App\Common\Csv\Contract\CsvViewModel as CsvViewModelContract;

/**
 * CsvDownLoad
 * @package App\Common\Csv
 */
class CsvDownLoad
{
    /**
     * @var string
     */
    protected string $fileName;

    /** @var CsvViewModelContract */
    protected CsvViewModelContract $viewModel;

    /**
     * Init
     *
     * @return void
     */
    public function __construct($fileName)
    {
        $this->setCsvFileName($fileName);
    }

    /**
     * @param CsvViewModelContract $viewModel
     * @return void
     */
    public function setCsvViewModel(CsvViewModelContract $viewModel)
    {
        $this->viewModel = $viewModel;
    }

    /**
     * @param string $fileName
     * @return void
     */
    public function setCsvFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function csvDownload(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        set_time_limit(600); //10分
        $response = new \Symfony\Component\HttpFoundation\StreamedResponse;

        $response->setCallback(function (){

            $file = new \SplFileObject('php://output', 'w');

            $viewModel = $this->viewModel;
            $headerData = array_values($viewModel->getHeader());
            $file->fwrite($this->convertFieldsToStringWithEnclosure($headerData));
            flush();
            // カーソルをOpenにして1行読み込んでCSV書き込み
            // RDB毎にやり方違う（後述）
            $builders = $viewModel->getBuilder();

            // クエリビルダでループ
            foreach($builders as $index => $builder) {
                $viewModel = clone $this->viewModel;
                // ViewModelにプロパティがあるとき (ビルダによって処理分岐させるなどを想定)
                if (property_exists($viewModel, 'index')) {
                    $viewModel->index = $index;
                }

                // SQL実行結果でループ
                $builder->chunk(500, function($list) use ($file, $viewModel){
                    foreach ($list as $row) {
                        $rowData = array_values($viewModel->convert($row));
                        $file->fwrite($this->convertFieldsToStringWithEnclosure($rowData));
                        flush();
                    }
                });
                unset($viewModel);
            }
        });

        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $this->fileName);

        return $response;
    }

    /**
     * convertFieldsToStringWithEnclosure
     *
     * @param array $field
     * @return string
     */
    private function convertFieldsToStringWithEnclosure(array $field): string
    {
        // 配列を変換して詰め替え
        foreach ($field as $key => $value) {
            // 項目をダブルクォーテーションで囲む（元々入ってるダブルクォーテーションはエスケープする）
            $field[$key] = '"'.str_replace('"', '""', $value).'"';;
        }
        return mb_convert_encoding(implode(',', $field)."\n", "Unicode", "UTF-8");
    }
}
