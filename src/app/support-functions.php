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

/**
 * Format datetime to d-m-Y
 *
 * @param DateTimeInterface $date
 * @return string|false
 */
function dateFormat(DateTimeInterface $date): string|false
{
    return $date ? date_format($date, 'd-m-Y') : '';
}

/**
 * Generate slug
 *
 * @param string $name
 * @return string
 */
function generateSlug(string $name): string
{
    // Generate slug
    $slug = mb_strtolower($name);
    $slug = str_replace(' - ', '-', $slug);
    $slug = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $slug);
    $slug = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $slug);
    $slug = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $slug);
    $slug = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $slug);
    $slug = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $slug);
    $slug = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $slug);
    $slug = preg_replace('/(đ)/', 'd', $slug);
    $slug = preg_replace('/[^a-z0-9-\s]/', '', $slug);
    $slug = preg_replace('/([\s]+)/', '-', $slug);

    return $slug;
}
