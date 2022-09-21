<?php
/**
 * UUIDを取得する。
 *
 * @return string uuid
 * @throws Exception
 */
function get_uuid(): string
{
    return \Ramsey\Uuid\Uuid::uuid4()->toString();
}

/**
 *
 * 	日付からN日過ぎの日付を取得
 *
 *  @return date
 */
function getNthDay($curdate,$n,$delimeter='-') {
	if (!isset($curdate)) {
		$curdate = date('Y-m-d');
	}
	if (!preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/",$curdate,$match)) {
		return $curdate;
	}
	$newdate = mktime(0,0,0,$match[2],$match[3],$match[1]);
	return date('Y'.$delimeter.'m'.$delimeter.'d', $newdate + ($n * 24 * 60 * 60));
};


/**
 *
 * 	日付からN時間過ぎの日付を取得
 *
 *  @return date
 */
function getNthHour($curdate, $diff=0,$delimeter='-') {
	if (!isset($curdate)) {
		$curdate = date('Y-m-d H:i:s');
	}
	if (!preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})\s([0-9]{2})\:([0-9]{2})\:([0-9]{2})/",$curdate,$match)) {
		return $curdate;
	}
	$tyear  = $match[1];
	$tmonth = $match[2];
	$tday   = $match[3];
	$thour  = $match[4];
    $tmin   = $match[5];
    $tsec   = $match[6];

	return date('Y'.$delimeter.'m'.$delimeter.'d H:i:s', mktime($thour,$tmin,$tsec,$tmonth,$tday,$tyear) + ($diff * 60 *60));
};


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
 * 初期パスワード用のランダム文字列を作る。
 *
 * @return string
 */
function makeRandomStrForEmployeePassword(): string
{
    $colSmall  = collect(range('a', 'z'))->random(5)->all();
    $colLarge  = collect(range('A', 'Z'))->random(5)->all();
    $colNum    = collect(range(0, 9))->random(5)->all();
    $password  = array_merge($colSmall, $colLarge, $colNum);

    return str_shuffle(implode($password));
}

/**
 * カスタマーの再発行用パスワードを作る。
 *
 * @return string
 */
function makeRandomStrForCustomerPassword(): string
{
    $colSmall  = collect(range('a', 'z'))->random(4)->all();
    $colLarge  = collect(range('A', 'Z'))->random(4)->all();
    $colNum    = collect(range(0, 9))->random(2)->all();
    $colSymbol = collect(['!','$','%','&','(',')','*','+','/'])->random(2)->all();
    $password  = array_merge($colSmall, $colLarge, $colNum, $colSymbol);

    return str_shuffle(implode($password));
}

/**
 * publicフォルダに配置されるリソースにキャッシュバスティング用のパラメーターを付与する。
 *
 * @param  string $resourcePath キャッシュバスティングを行いたいリソースのパス。
 * @param  string $prefix 実態ファイルのディレクトリを示すプリフィックス
 * @return string キャッシュバスティング用のパラメーターを付与したリソースのパス
 */
function busting(string $resourcePath, string $prefix = ''): string
{
    $fullPath = public_path($prefix) . $resourcePath;
    if (empty($resourcePath) || !file_exists($fullPath)) {
        return $resourcePath;
    }
    return sprintf('%1$s?id=%2$s', $resourcePath, filemtime($fullPath));
}

/**
 * 入力値に含まれる改行コードを変換する。
 *
 * @param  mixed $value 入力値
 * @return array|string|null
 */
function convertCrlf(mixed $value): array|string|null
{
    // ネストされた値を処理する。
    if (is_array($value)) {
        $container = [];
        foreach ($value as $childKey => $child) {
            $container[$childKey] = convertCrlf($child);
        }
        return $container;
    }
    return preg_replace(['/\r\n/','/\r/','/\n/'], "\n", $value);
}

/**
 * replaceSevenBankRule
 * セブン銀の受付可能文字列に置換する
 *
 * @param string $target
 * @return string
 */
function replaceSevenBankRule(string $target): string
{
    //置換対象文字列 -> セブン銀使用不可文字
    $searchString = ['ー', 'ｰ','ｧ','ｨ','ｩ','ｪ','ｫ','ｬ','ｭ','ｮ','ｯ','ヮ'];

    //置換後文字列
    $replace =  ['-','-','ｱ','ｲ','ｳ','ｴ','ｵ','ﾔ','ﾕ','ﾖ','ﾂ','ﾜ'];

    //r=全角英字,k=全角カタカナ,a=全角文字,s=全角スペース
    return str_replace(
        $searchString,
        $replace,
        mb_convert_kana($target, "arks")
    );
}