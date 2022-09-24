<?php
namespace App\Common\Database;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * 実行されたクエリをログ出力する機能を提供するクラス。
 * @package \App\Common\Database
 */
class QueryDebugger
{
    /**
     * デバッガーを設定する。
     * @return void
     */
    public static function setup(): void
    {
        if (config('database.debug_query', false)) {
            DB::listen(function ($sql) {
                foreach ($sql->bindings as $index => $binding) {
                    if ($binding instanceof DateTime) {
                        $sql->bindings[$index] = $binding->format('Y-m-d H:i:s:v');
                    } else {
                        if (is_string($binding)) {
                            $sql->bindings[$index] = "'$binding'";
                        }
                    }
                }

                $query = str_replace([ '%', '?' ], [ '%%', '%s' ], $sql->sql);
                $query = vsprintf($query, $sql->bindings);

                // パスワードに関連するクエリはログに出さない
                if (Str::contains($query, 'password', true)) {
                    $query = 'this query has password field or context. ignored...';
                }
                $query = "[ExecutionTime: {$sql->time}ms] {$query}";

                Log::channel('sql')->info($query);
            });
        }
    }
}
