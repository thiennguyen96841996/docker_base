<?php
namespace GLC\Platform\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use GLC\Platform\View\Contracts\ViewModel as ViewModelContract;

/**
 * ViewModelを扱うリポジトリで使用するトレイト。
 *
 * @package GLC\Platform\Repository
 * @author  TinhNC <tinhhang22@gmail.com>
 */
trait ViewModelRepositoryTrait
{
    /**
     * このリポジトリーで使用するViewModelオブジェクト
     * @var ViewModelContract|null
     */
    private ?ViewModelContract $viewModel;

    /**
     * Modelオブジェクトから単一のViewModelオブジェクトを作成する。
     *
     * @param  \Illuminate\Database\Eloquent\Model $model ViewModelに変換したいModelクラス
     * @return mixed|null ViewModelContractを実装するクラス or null
     */
    protected function makeViewModel(Model $model): ?ViewModelContract
    {
        if (empty($this->viewModel)) {
            Log::channel('error')->error('ViewModel is not set.');
            return null;
        }

        $viewModel = clone $this->viewModel;
        $viewModel->setAttributes($model);

        return $viewModel;
    }

    /**
     * ModelオブジェクトのコレクションからViewModelオブジェクトのコレクションを作成する。
     *
     * @param  \Illuminate\Support\Collection $models Modelクラスのコレクション
     * @return \Illuminate\Support\Collection|null ViewModelContractを実装するクラスのコレクション or null
     */
    protected function makeViewModels(Collection $models): ?Collection
    {
        if (empty($this->viewModel)) {
            Log::channel('error')->error('ViewModel is not set.');
            return null;
        }

        $viewModels = [];
        foreach ($models as $model) {
            $viewModel = clone $this->viewModel;
            $viewModel->setAttributes($model);
            $viewModels[] = $viewModel;
        }
        return collect($viewModels);
    }

    /**
     * ViewModelを設定する。
     *
     * @param ViewModelContract $viewModel ViewModelContractを実装したオブジェクト
     */
    public function setViewModel(ViewModelContract $viewModel)
    {
        $this->viewModel = $viewModel;
    }
}