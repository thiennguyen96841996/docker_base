<?php
/**
 * (キャッシュ対策として)最終更新日時パラメーターを付与したパスを作成する。
 * @param string $filePath パラメーターを付与したいpublicフォルダのファイルパス
 * @param string $baseDirName アプリケーション毎のディレクトリ名
 * @return string パラメーターをつけたファイルパス
 */
function busting(string $filePath, string $baseDirName): string
{
    if (empty($baseDirName)) {
        $t = filemtime(public_path($filePath));
    } else {
        $t = filemtime(public_path($baseDirName).'/'.$filePath);
    }
    return sprintf('%1$s?t=%2$s', $filePath, $t);
}
