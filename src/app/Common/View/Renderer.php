<?php
namespace App\Common\View;

use ArrayAccess;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;
use App\Common\View\Contract\Renderer as RendererContract;
use App\Common\View\Contract\ViewModel as ViewModelContract;
use App\Common\Support\ArrayAccessible;

/**
 * Bladeから使用する描画系のサポートクラス。
 *
 * @package App\Common\View
 */
class Renderer implements ArrayAccess, RendererContract
{
    use ArrayAccessible;
    /**
     * Paginatorの保存キー
     * @var string
     */
    const KEY_PAGINATOR = '__PAGINATOR__';

    /**
     * ViewModelの保存キー
     * @var string
     */
    const KEY_VIEW_MODEL = '__VIEW_MODEL__';

    /**
     * 検索条件の保存キー
     * @var string
     */
    const KEY_SEARCH_CONDITIONS = '__SEARCH_CONDITIONS__';

    /**
     * ページタイトルの保存キー
     * @var string
     */
    const KEY_PAGE_TITLE = '__PAGE_TITLE__';

    /**
     * バリデーションのメッセージバッグの保存キー
     * @var string
     */
    const KEY_VALIDATION_ERROR_MESSAGE_BAG = '__VALIDATION_ERROR_MESSAGE_BAG__';

    /**
     * Paginatorの総件数を表示する文言のフォーマット。
     * @var string
     */
    const PAGINATOR_TOTAL_LINE_FORMAT = 'Hiển thị %2$d〜%3$d trong tổng số %1$d mục';

    /**
     * 検索条件の配列を取得する。
     *
     * @return array 検索条件の配列
     */
    public function getSearchConditions(): array
    {
        return $this->get(self::KEY_SEARCH_CONDITIONS, []);
    }

    /**
     * 検索条件の配列を設定する。
     *
     * @param  array $searchConditions 検索条件の配列
     * @return void
     */
    public function setSearchConditions(array $searchConditions)
    {
        $this->set(self::KEY_SEARCH_CONDITIONS, $searchConditions);
    }

    /**
     * Paginatorを取得する。
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|null LengthAwarePaginatorオブジェクト or null
     */
    public function getPaginator(): ?LengthAwarePaginator
    {
        return $this->get(self::KEY_PAGINATOR);
    }

    /**
     * Paginatorを設定する。
     *
     * @param  \Illuminate\Pagination\LengthAwarePaginator $paginator LengthAwarePaginatorオブジェクト
     * @return void
     */
    public function setPaginator(LengthAwarePaginator $paginator)
    {
        $this->set(self::KEY_PAGINATOR, $paginator);
    }

    /**
     * PaginatorのHTMLソースを出力する。
     *
     * @param  string|null $viewPath カスタムされたViewファイルのパス
     * @param  array $searchConditions 検索条件の配列
     * @return string PaginatorのHTMLソース or 空文字列
     */
    public function renderPaginator(string $viewPath = null, array $searchConditions = []): View
    {
        if (!empty($pg = $this->getPaginator())) {
            if (!empty($searchConditions) || !empty($searchConditions = $this->getSearchConditions())) {
                $pg->appends($searchConditions);
            }
            return $pg->render($viewPath);
        }
        return '';
    }

    /**
     * ViewModelを取得する。
     *
     * @return \App\Common\View\Contracts\ViewModel|null ViewModelの実装を持つオブジェクト or null
     */
    public function getViewModel(): ?ViewModelContract
    {
        return $this->get(self::KEY_VIEW_MODEL);
    }

    /**
     * ViewModelを設定する。
     *
     * @param  \App\Common\View\Contracts\ViewModel|null $viewModel ViewModelの実装を持つオブジェクト
     * @return void
     */
    public function setViewModel(?ViewModelContract $viewModel)
    {
        $this->set(self::KEY_VIEW_MODEL, $viewModel);
    }

    /**
     * ページタイトルを取得する。
     *
     * @param  string $default デフォルトのページタイトル
     * @return string
     */
    public function getPageTitle(string $default = ''): string
    {
        return $this->get(self::KEY_PAGE_TITLE, $default);
    }

    /**
     * ページタイトルを設定する。
     *
     * @param  string $pageTitle 設定したいページタイトル
     * @return void
     */
    public function setPageTitle(string $pageTitle)
    {
        $this->set(self::KEY_PAGE_TITLE, $pageTitle);
    }

    /**
     * バリデーションのメッセージバッグを取得する。
     *
     * @return \Illuminate\Support\ViewErrorBag|null ViewErrorBagオブジェクト or null
     */
    public function getValidationErrorMessageBag(): ?ViewErrorBag
    {
        return $this->get(self::KEY_VALIDATION_ERROR_MESSAGE_BAG, null);
    }

    /**
     * バリデーションのメッセージバッグを設定する。
     *
     * @param  \Illuminate\Support\ViewErrorBag $error ViewErrorBagオブジェクト
     * @return void
     */
    public function setValidationErrorMessageBag(ViewErrorBag $error)
    {
        $this->set(self::KEY_VALIDATION_ERROR_MESSAGE_BAG, $error);
    }

    /**
     * <p>old()に指定されたデータがある場合はそれを、ない場合はリクエスト・モデル・配列からデータを取得する。
     * <br>※使用用途は入力テンプレートで編集時に現在の登録内容をテンプレートに反映するのがメイン。</p>
     *
     * @param  string $key 取得したいデータのキー
     * @param  ViewModelContract|array|null $else ビューモデル or 配列 or null
     * @param  string|null $property ビューモデルのプロパティ or 配列のキー
     * @return mixed 取得したデータ
     */
    public function oldOrElse(string $key, $else = null, ?string $property = null): mixed
    {
        if (session()->exists('_old_input.'.$key)) {
            $data = old($key, '');
        } else {
            // ビューモデルがnullの場合はリクエストから取得
            if (is_null($else)) {
                $data = Arr::get($this->getSearchConditions(), $key, '');
            } else {
                $property = (is_null($property)) ? $key : $property;
                if ($else instanceof ViewModelContract) {
                    $data = $else->$property ?? '';
                } else {
                    $data = Arr::get($else, $property, '');
                }
            }
        }
        return $data;
    }

    /**
     * old()でデータが取得できない場合に同様のキーでリクエストデータを探し、ある場合にはそれを返す。
     * ※ Form(GET)での使用を想定。
     *
     * @param  string $key 取得したいデータのキー
     * @return mixed 取得したデータ
     */
    public function oldWithRequest(string $key)
    {
        $old = old($key);
        if (empty($old)) {
            $old = Arr::get($this->getSearchConditions(), $key);
        }
        return $old;
    }

    /*
     * Paginatorの総件数を表示する文言を取得する。
     *
     * @return string
     */
    public function renderPaginatorTotalLine(): string
    {
        if (!empty($pg = $this->getPaginator())) {
            // 前のページに表示されたデータの終了位置 + 1 がこのページの開始位置
            $startPosition = $pg->perPage() * ($pg->currentPage() - 1) + 1;
            // このページに表示されるべきデータの終了位置はページ数×ページ表示件数
            $endPosition = $pg->perPage() * $pg->currentPage();
            // 最後のページの終わりは総件数と一致する
            $remainingCount = $endPosition >= $pg->total() ? $pg->total(): $endPosition;

            return sprintf(self::PAGINATOR_TOTAL_LINE_FORMAT,
                $pg->total(),
                $pg->total() != 0 ?$startPosition : 0,
                $pg->onFirstPage() && $pg->total() >= $pg->perPage() ? $endPosition : $remainingCount,
                $pg->lastPage()
            );
        }
        return '';
    }

    /**
     * @param string $auth
     * @return bool
     */
    public function checkRole(string $auth): bool
    {
        return in_array($auth, UserDefs::getRole(Auth::user()->role));
    }
}
