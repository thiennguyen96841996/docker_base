<?php

namespace App\Common\Project\Contract;

use App\Common\Project\Model\Project;
use App\Common\Database\Contract\ModelRepository;

/**
 * Projectモデルのデータ操作を扱うクラスを表すインターフェイス。
 * @package \App\Common\Project
 */
interface ProjectRepository extends ModelRepository
{
    /**
     * 単一の管理Project情報を登録する。
     * @param  array<string, mixed> $params
     * @return \App\Common\Project\Model\Project
     * @throws \Throwable
     */
    public function store(array $params): Project;

    /**
     * 単一の管理Project情報を更新する。
     * @param  array<string, mixed> $params
     * @param  \App\Common\Project\Model\Project $project
     * @return void
     * @throws \Throwable
     */
    public function update(Project $project, array $params): void;

    /**
     * 単一の管理ユーザー情報を削除する。
     * @param  \App\Common\Project\Model\Project $project
     * @return void
     * @throws \Throwable
     */
    public function delete(Project $project): void;
}
