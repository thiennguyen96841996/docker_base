<?php
namespace App\Common\Http\Resource;

use Carbon\Carbon;

/**
 * 日付をフォーマットするトレイト。
 * @package \App\Common\Http
 */
trait DateAttributeFormatter
{
    /**
     * 日付をフォーマットする。
     * @param  string|null $date
     * @return string|null
     */
    public function formatDate(?string $date): ?string
    {
        if (!is_null($date)) {
            return Carbon::parse($date)->format('Y/m/d H:i:s');
        }
        return null;
    }
}
