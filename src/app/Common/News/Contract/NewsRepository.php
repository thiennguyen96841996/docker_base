<?php

namespace App\Common\News\Contract;

use App\Common\News\Model\News;
use App\Common\Database\Contract\ModelRepository;

/**
 * Newsモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\News\Contract
 */
interface NewsRepository extends ModelRepository
{
    /**
     * 単一のクライアントのニュース情報を登録する。
     * @param  array<string, mixed> $params
     * @return News
     * @throws \Throwable
     */
    public function store(array $params): News;

    /**
     * 単一のクライアントのニュース情報を更新する。
     * @param  array<string, mixed> $params
     * @param  News $news
     * @return void
     * @throws \Throwable
     */
    public function update(News $news, array $params): void;

    /**
     * 単一のクライアントのニュース情報を削除する。
     * @param  News $news
     * @return void
     * @throws \Throwable
     */
    public function delete(News $news): void;
}
