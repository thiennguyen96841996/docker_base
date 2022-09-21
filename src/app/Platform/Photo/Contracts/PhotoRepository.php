<?php

namespace GLC\Platform\Photo\Contracts;

/**
 * 画像に関連した処理を行うリポジトリを表すインターフェイス。
 *
 * @package GLC\Platform\Photo\Contracts
 */
interface PhotoRepository
{
    /**
     * バイナリデータを基に画像を生成し、画面に表示する
     *
     * @param string $photoBinary
     * @return void
     */
    public function displayPhoto(string $photoBinary);
}