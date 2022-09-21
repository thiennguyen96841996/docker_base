<?php
namespace GLC\Platform\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;
use GLC\Platform\Database\Models\AbsBaseModel;
use GLC\Platform\Notification\Notifiable;

/**
 * ユーザーの情報を扱うモデルクラス。
 * ※ ログインやパスワードに関連した処理はそれを使用するアプリケーション側で実装すること。
 *
 * <pre>
 * +--------------------------+--------------+------+-----+---------+-------+
 * | Field                    | Type         | Null | Key | Default | Extra |
 * +--------------------------+--------------+------+-----+---------+-------+
 * | user_id                  | char(10)     | NO   | PRI | NULL    |       |
 * | user_name                | varchar(80)  | NO   |     | NULL    |       |
 * | email                    | varchar(255) | NO   | UNI | NULL    |       |
 * | password                 | varchar(60)  | NO   |     | NULL    |       |
 * | remember_token           | varchar(100) | YES  |     | NULL    |       |
 * | role                     | char(2)      | NO   |     | NULL    |       |
 * | last_login_at            | timestamp    | YES  |     | NULL    |       |
 * | last_password_updated_at | timestamp    | YES  |     | NULL    |       |
 * | created_at               | timestamp    | YES  |     | NULL    |       |
 * | updated_at               | timestamp    | YES  |     | NULL    |       |
 * +--------------------------+--------------+------+-----+---------+-------+
 * </pre>
 *
 * @package GLC\Platform\User\Models
 * @author  Odo Ari <flasanpal@yahoo.co.jp>
 *
 * [ For IDE ]
 * @method $this|\Illuminate\Database\Eloquent\Builder whereMultiConditions(array $searchConditions)
 * @method \Illuminate\Pagination\LengthAwarePaginator asPaginator(string $path, int $page)
 *
 * @property string user_id                          ユーザーID
 * @property string user_name                        名前
 * @property string email                            メールアドレス
 * @property string password                         パスワード
 * @property string remember_token                   ログイン省略用トークン
 * @property string role                             ID区分
 * @property \Carbon\Carbon last_login_at            最終ログイン日時
 * @property \Carbon\Carbon last_password_updated_at パスワード最終更新日時
 * @property \Carbon\Carbon created_at               作成日時
 * @property \Carbon\Carbon updated_at               更新日時
 */
class User extends AbsBaseModel
{
    use Notifiable, HasFactory;

    /**
     * テーブル名の定義。
     * @var string
     */
    const TABLE_NAME = 'users';

    /**
     * モデルが使用するテーブル名の定義。
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * モデルのPrimaryKeyとなるカラムの名称。
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * PrimaryKeyの型の定義。
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * PrimaryKeyがAutoIncrementかどうかの定義。
     * @var bool
     */
    public $incrementing = true;

    /**
     * 取得した結果の配列には含めないカラムの定義。
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Carbonに自動変換する日付型カラムの定義。
     * @var array
     */
    protected $dates = [
        'last_login_at',
        'last_password_updated_at',
        'created_at',
        'updated_at',
    ];

    /**
     * このモデルに対応したファクトリークラスを作成して返す。
     *
     * @return \GLC\Platform\User\Models\Factories\UserFactory
     */
    public static function newFactory(): Factories\UserFactory
    {
        return \GLC\Platform\User\Models\Factories\UserFactory::new();
    }

    /**
     * Notificationのメール送信で使用するメールアドレスを取得する。
     *
     * @return string
     */
    public function routeNotificationForMail(): string
    {
        return $this->email;
    }

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
        // ユーザーID
        if (!empty($id = Arr::get($searchConditions, 'id'))) {
            if(is_array($id)) {
                $builder->whereIn(self::TABLE_NAME . '.id', $id);
            } else {
                $builder->where(self::TABLE_NAME . '.id', '=', $id);
            }
        }
        // ユーザーID (NOT条件)
        if (!empty($notId = Arr::get($searchConditions, 'not_id'))) {
            $builder->where(self::TABLE_NAME . '.id', '<>', $notId);
        }
        // メールアドレス
        if (!empty($email = Arr::get($searchConditions, 'email'))) {
            if(is_array($email)) {
                $builder->whereIn(self::TABLE_NAME . '.email', $email);
            } else {
                $builder->where(self::TABLE_NAME . '.email', '=', $email);
            }
        }

        return $builder;
    }
}