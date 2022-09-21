<?php
namespace GLC\Platform\Sms\Models;

use Illuminate\Database\Eloquent\Builder;
use GLC\Platform\Database\Models\AbsBaseModel;
use GLC\Platform\Database\MysqlCryptor;

/**
 * SMSで送信する認証用コードの情報を扱うモデルクラス。
 *
 * <pre>
 * +------------+--------------+------+-----+---------+----------------+
 * | Field      | Type         | Null | Key | Default | Extra          |
 * +------------+--------------+------+-----+---------+----------------+
 * | id         | int unsigned | NO   | PRI | NULL    | auto_increment |
 * | tel        | varchar(100) | NO   |     | NULL    |                |
 * | code       | varchar(6)   | NO   |     | NULL    |                |
 * | created_at | timestamp    | YES  |     | NULL    |                |
 * | updated_at | timestamp    | YES  |     | NULL    |                |
 * +------------+--------------+------+-----+---------+----------------+
 * </pre>
 *
 * @package GLC\Platform\Sms\Models
 * @author  TinhNC <tinhhang22@gmail.com>
 *
 * [ For IDE ]
 * @method $this|\Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 *
 * @property int id                    ID
 * @property string tel                電話番号
 * @property string code               認証用コード
 * @property \Carbon\Carbon created_at 作成日時
 * @property \Carbon\Carbon updated_at 更新日時
 */
class VerificationSms extends AbsBaseModel
{
    /**
    * テーブル名の定義。
    * @var string
    */
    const TABLE_NAME = 'verification_sms';

    /**
     * モデルが使用するテーブル名の定義。
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * Carbonに自動変換する日付型カラムの定義。
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

//〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜
//   Scopes
//〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜・〜
    /**
     * 検索条件に合わせてWhere句を設定する。
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder Builderオブジェクト
     * @param  array $searchConditions 検索条件の配列
     * @return \Illuminate\Database\Eloquent\Builder Builderオブジェクト
     */
    public function scopeWhereMultiConditions(Builder $builder, array $searchConditions): Builder
    {
        foreach ($searchConditions as $key => $value) {
            if (empty($value)) {
                continue;
            }
            switch ($key) {
                case 'tel' : //電話番号
                    $builder->where($key, '=', (new MysqlCryptor())->encrypt($value, config('app.encrypt_key')));
                    break;
                default:
                    $this->addWhereStatement($builder, $searchConditions, $key);
                    break;
            }
        }
        return $builder;
    }
}