<?php
namespace GLC\Platform\Sample\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use GLC\Platform\Database\Definitions\DatabaseDefs;
use GLC\Platform\Repository\ViewModelRepositoryTrait;
use GLC\Platform\Sample\Contracts\SampleRepositoryContract;
use Illuminate\Support\Arr;

//TODO:後でチェック、addしたよ〜
use GLC\Platform\Sample\Models\Sample;
use GLC\Platform\Sample\ViewModels\SampleViewModel;

class SampleRepository implements SampleRepositoryContract
{
    use ViewModelRepositoryTrait;

//    public function __construct()
//    {
//
//    }


    public function getFugafuga(array $arg)
    {

    }
    public function getCollection(array $searchConditions): ?Collection
    {
        /** @var \Wanriku\Platform\Sample\Models\Sample $builder */
        $builder = Sample::on(DatabaseDefs::CONNECTION_NAME_READ)
            ->addSelect([
                Sample::TABLE_NAME. '.*',
            ]);

        return $builder
            ->whereMultiConditions($searchConditions)
            ->get();
    }
    public function getModel(array $searchConditions)
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1 ? $collection->first(): null;
    }
    public function getViewModelCollection(array $searchConditions = []): ?Collection
    {
        // TODO: Implement getViewModelCollection() method.
    }

    public function getViewModelPaginator(string $path, int $page, array $searchConditions = []): LengthAwarePaginator
    {
        /** @var \Wanriku\Platform\Sample\Models\Sample $builder */
        $builder = Sample::on(DatabaseDefs::CONNECTION_NAME_READ)
            ->addSelect([
                '*'
            ])
            ->orderBy('id', 'desc');

        $paginator = $builder
            ->whereMultiConditions($searchConditions)
            ->asPaginator($path, $page);

        return $paginator->setCollection(
            $this->makeViewModels($paginator->getCollection())
        );
    }

    public function getViewModel(array $searchConditions): ?SampleViewModel
    {
        $collection = $this->getCollection($searchConditions);

        return $collection->count() === 1
            ? $this->makeViewModel($collection->first())
            : null;
    }

    /**
     * @param array $storeData
     * @throws \Throwable
     */
    public function store(array $storeData)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)
            ->transaction(function () use ($storeData) {
                //モデルインスタンス化
                $sample = new Sample();

                $sample->id = null;//オートインクリメント
                $sample->text  = Arr::get($storeData, 'text');
                $sample->name  = Arr::get($storeData, 'name');
                $sample->email = Arr::get($storeData, 'email');

                $sample->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();

        });
    }

    /**
     * @param Sample $sample
     * @param array $updateData
     * @throws \Throwable
     */
    public function update(Sample $sample, array $updateData)
    {
        DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)
            ->transaction(function () use ($sample, $updateData) {
                $sample->name = Arr::get($updateData, 'name');
                $sample->text = Arr::get($updateData, 'text');
                $sample->email = Arr::get($updateData, 'email');

                $sample->setConnection(DatabaseDefs::CONNECTION_NAME_WRITE)->save();
            });
    }

    public function delete(Sample $sample): bool
    {
        return DB::connection(DatabaseDefs::CONNECTION_NAME_WRITE)
            ->transaction(function () use($sample) {
                $sample->delete();
                return true;
            });
        return false;
    }
}

