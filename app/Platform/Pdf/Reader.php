<?php
namespace GLC\Platform\Pdf;

//use Illuminate\Support\Arr;
//use SplFileObject;
//use GLC\Platform\Csv\Contracts\CsvProcessor as CsvProcessorContract;
//use GLC\Platform\Csv\Exceptions\ConvertEncodingException;
//use GLC\Platform\Csv\Exceptions\ProcessFailedException;

use mikehaertl\wkhtmlto\Pdf;


/**
 * PDFデータを読み込むためのクラス。
 *
 * @package GLC\Platform\Csv
 */
class Reader
{

    /**
     * CSVを読み込む。
     *
     * @param  string $filePath
     * @return void
     */
    public function render($html, $filename = null, $option = [])
    {
        $option =  [
            'page-width' => 210, //A4
            'page-height' => 297, //A4
        ];

        $option = [
            'binary' => '/usr/local/bin/wkhtmltopdf',
            'dpi'           => 400,
            'encoding'      => 'UTF-8',
            'margin-top'    => 10,
            'margin-right'  => 10,
            'margin-bottom' => 10,
            'margin-left'   => 10,
            'page-width' => 210, //A4
            'page-height' => 297, //A4
            'no-outline'
        ];

        $pdf = new Pdf($option);
        $pdf->addPage($html);

        //引数にファイル名をいれるとダウンロード、いれないとプレビュー
        if(!empty($filename)) {
            header('Content-Disposition: attachment; filename*=UTF-8\'\'' . rawurlencode($filename));
        }

        if (! $pdf->send()) {
            echo 'error' . PHP_EOL;
            echo $pdf->getError();
        }
    }
}