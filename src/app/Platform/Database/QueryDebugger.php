<?php
namespace GLC\Platform\Database;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * 実行されたクエリをデバックする為の設定を行うクラス。
 *
 * @package GLC\Platform\Database
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class QueryDebugger
{
    /**
     * デバッガーを設定する。
     *
     * @return void
     */
    public function setup()
    {
        if (config('database.debug', false)) {
            DB::listen(function ($sql) {
                foreach ($sql->bindings as $index => $binding) {
                    if ($binding instanceof DateTime) {
                        $sql->bindings[$index] = $binding->format('\'Y-m-d H:i:s\'');
                    } else {
                        if (is_string($binding)) {
                            $sql->bindings[$index] = "'$binding'";
                        }
                    }
                }

                $query = str_replace([ '%', '?' ], [ '%%', '%s' ], $sql->sql);
                $query = vsprintf($query, $sql->bindings);
                $query = "[ExecutionTime: {$sql->time}ms] {$query}";
                Log::channel('sql')->info($query);
            });
        }
    }
}