<?php

namespace GLC\Platform\Photo\Repositories;

use GLC\Platform\Photo\Contracts\PhotoRepository as RepositoryContract;

/**
 * 画像に関連した処理を行うリポジトリクラス。
 *
 * @package GLC\Platform\Photo\Repositories
 */
Class PhotoRepository implements RepositoryContract
{
    /**
     * PhotoRepository constructor.
     *
     */
    public function __construct()
    {
    }

    /**
     * バイナリデータを基に画像を生成し、画面に表示する
     *
     * @param string $photoBinary 画像のバイナリデータ文字列
     * @return void
     */
    public function displayPhoto(string $photoBinary)
    {
        // バイナリデータから、画像のMIMEタイプを取得
        $mimeType = $this->getMimeType($photoBinary);
        // バイナリデータとMIMEタイプを基に、画面表示用の画像オブジェクトを生成
        $this->createImageObject($photoBinary, $mimeType);
    }

    /**
     * バイナリ文字列を基に、画像のMIMEタイプを取得する
     * 取得できない場合、jpegとみなす
     *
     * @param string $photoBinary 写真のバイナリ文字列
     * @return string MIMEタイプ
     */
    private function getMimeType(string $photoBinary)
    {
       $imageSizes = getimagesize('data:application/octet-stream;base64,' . $photoBinary);
       return !empty($imageSizes['mime']) ? $imageSizes['mime'] : 'image/jpeg';
    }

    /**
     * バイナリ文字列とMIMEタイプを基に、画像オブジェクトを生成
     *
     * @param string $photoBinary 画像のバイナリ文字列
     * @param string $mimeType 画像のMIMEタイプ
     * @param int $quality 画像の品質 ※imagejpeg()の第三引数で渡す値 (MIN 0～100 MAX, 75がデフォルト)
     * @return bool|string
     */
    private function createImageObject(string $photoBinary, string $mimeType, int $quality=75)
    {
        // バイナリ文字列からイメージオブジェクトを生成
        $image = imagecreatefromstring(base64_decode($photoBinary));

        // Content-Typeヘッダー設定
        header('Content-Type: '.$mimeType);

        // 画像のMIMEタイプによって出力方法を変える
        return match ($mimeType) {
            'image/gif' => imagegif($image, null),
            'image/png', 'image/x-png' => imagepng($image, null, 3),
            default => imagejpeg($image, null, $quality),
        };
    }

}