<?php
namespace App\Common\Post\Contract;

use App\Common\Post\Model\Post;
use App\Common\Database\Contract\ModelRepository;

/**
 * Postモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\Post
 */
interface PostRepository extends ModelRepository
{
    /**
     * 単一の管理Post情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Post\Model\Post
     * @throws \Throwable
     */
    public function store(array $params): Post;

    /**
     * 単一の管理Post情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Post\Model\Post $post
     * @return void
     * @throws \Throwable
     */
    public function update(Post $post, array $params): void;

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\Post\Model\Post $post
     * @return void
     * @throws \Throwable
     */
    public function delete(Post $post): void;
}
