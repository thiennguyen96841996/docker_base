<?php
namespace GLC\Platform\Validation;

use Illuminate\Support\Facades\Config;

/**
 * メールアドレスのバリデーションを行うカスタムバリデーションクラス。
 *
 * このクラスでは昔のガラケーメールアドレスで使用可能であった一般的には許容されないメールアドレスを許容できる。
 * 詳細はリンク先を参照のこと。
 * http://wada811.blogspot.com/2013/03/best-email-format-check-regex-in-php.html ([PHP]実用的なメールアドレスの正規表現)
 *
 * @package GLC\Platform\Validation
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class GalapagosEmailValidator
{
    /**
     * <p>メールアドレスのバリデーションを実行する。</p>
     *
     * @param  string $attribute formの属性名
     * @param  mixed $value バリデートする値
     * @param  array $parameters 拡張パラメーター
     * @return bool バリデーションに適合するかどうか
     */
    public function validateGalapagosEmail($attribute, $value, $parameters): bool
    {
        // 文字列でなければ認めない。
        if (!is_string($value)) {
            return false;
        }

        $trim_input = preg_replace('/\A\s+|\s+\z/u', '', $value);

        $wsp              = '[\x20\x09]';                                   // 半角空白と水平タブ
        $v_char           = '[\x21-\x7e]';                                  // ASCIIコードの ! から ~ まで
        $quoted_pair      = "\\\\(?:{$v_char}|{$wsp})";                     // \ を前につけた quoted-pair 形式なら \ と " が使用できる
        $q_text           = '[\x21\x23-\x5b\x5d-\x7e]';                     // $vchar から \ と " を抜いたもの。\x22 は " , \x5c は \
        $q_content        = "(?:{$q_text}|{$quoted_pair})";                 // quoted-string 形式の条件分岐
        $quoted_string    = "\"{$q_content}+\"";                            // " で 囲まれた quoted-string 形式。
        $a_text           = '[a-zA-Z0-9!#$%&\'*+\-\/\=?^_`{|}~]';           // 通常、メールアドレスに使用出来る文字
        $dot_atom         = "{$a_text}+(?:[.]{$a_text}+)*";                 // ドットが連続しない RFC 準拠形式をループ展開で構築
        $local_part       = "(?:{$dot_atom}|{$quoted_string})";             // local-page は dot-atom 形式 または quoted-string 形式のどちらか
        // ドメイン部分の判定強化
        $al_num           = '[a-zA-Z0-9]';                                  // domain は先頭英数字
        $sub_domain       = "{$al_num}+(?:-{$al_num}+)*";                   // hyphenated alnum をループ展開で構築
        $domain           = "(?:{$sub_domain})+(?:[.](?:{$sub_domain})+)+"; // ハイフンとドットが連続しないように $sub_domain をループ展開
        $addr_spec        = "{$local_part}[@]{$domain}";                    // 合成
        // 昔の携帯電話メールアドレス用
        $dot_atom_loose   = "{$a_text}+(?:[.]|{$a_text})*";                 // 連続したドットと @ の直前のドットを許容する
        $local_part_loose = $dot_atom_loose;                                // 昔の携帯電話メールアドレスで quoted-string 形式なんてあるわけない。たぶん。
        $addr_spec_loose  = "{$local_part_loose}[@]{$domain}";              // 合成

        if (Config::get('validation.email_peculiar_format', true)) {
            $regexp = $addr_spec_loose;
        }else{
            $regexp = $addr_spec;
        }

        return preg_match("/\A{$regexp}\z/", $trim_input);
    }
}