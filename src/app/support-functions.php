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

/**
 * 初期パスワード用のランダム文字列を作る。
 *
 * @return string
 */
function makeRandomStrForPassword(): string
{
    $colSmall  = collect(range('a', 'z'))->random(4)->all();
    $colLarge  = collect(range('A', 'Z'))->random(4)->all();
    $colNum    = collect(range(0, 9))->random(2)->all();
    $colSymbol = collect(['!','$','%','&','(',')','*','+','/'])->random(2)->all();
    $password  = array_merge($colSmall, $colLarge, $colNum, $colSymbol);

    return str_shuffle(implode($password));
}

/**
 * 開発環境かどうかを取得する。
 *
 * @return bool
 */
function is_local(): bool
{
    return config('app.env') === 'development';
}

/**
 * ステージング環境かどうかを取得する。
 *
 * @return bool
 */
function is_staging(): bool
{
    return config('app.env') === 'staging';
}

/**
 * 本番環境かどうかを取得する。
 *
 * @return bool
 */
function is_production(): bool
{
    return config('app.env') === 'production';
}
