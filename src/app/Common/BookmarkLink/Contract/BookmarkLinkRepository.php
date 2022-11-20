<?php
namespace App\Common\BookmarkLink\Contract;

use App\Common\BookmarkLink\Model\BookmarkLink;
use App\Common\Database\Contract\ModelRepository;

/**
 * BookmarkLink repository contract
 * @package \App\Common\Sample
 */
interface BookmarkLinkRepository extends ModelRepository
{
    /**
     * 単一のBookmarkLink情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\BookmarkLink\Model\BookmarkLink
     * @throws \Throwable
     */
    public function store(array $params): BookmarkLink;

    /**
     * 単一の管理BookmarkLinkを更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\BookmarkLink\Model\BookmarkLink $sample
     * @return void
     * @throws \Throwable
     */
    public function update(BookmarkLink $Sample, array $params): void;

    /**
     * 単一の管理BookmarkLinkを削除する。
     * @param  \App\Common\BookmarkLink\Model\BookmarkLink $sample
     * @return void
     * @throws \Throwable
     */
    public function delete(BookmarkLink $sample): void;
}
