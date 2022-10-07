<?php
namespace App\Common\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Common\View\Contract\ViewModel as ViewModelContract;

/**
 * ViewModelを扱うリポジトリで使用するトレイト。
 *
 * @package App\Common\Repository
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
     * @param  \Illuminate\Database\Eloquent\Collection $models Modelクラスのコレクション
     * @return \Illuminate\Database\Eloquent\Collection|null ViewModelContractを実装するクラスのコレクション or null
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

        return Collection::make($viewModels);
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
