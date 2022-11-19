<?php

namespace App\Common\Post\ViewModel;

use App\Common\Database\MysqlCryptorTrait;
use App\Common\View\Contract\ViewModel as ViewModelContract;
use App\Common\View\ViewModelable;
use Carbon\Carbon;

class PostViewModel implements ViewModelContract
{
    use ViewModelable, MysqlCryptorTrait;

    /**
     * get decrypted client name
     *
     * @return string
     */
    public function getClientName(): string
    {
        return $this->decrypt($this->client_name);
    }

    /**
     * get published at
     *
     * @return string
     */
    public function getPublishedAt(): string
    {
        return Carbon::parse($this->published_at)->format('d-m-Y');
    }

    /**
     * get closed at
     *
     * @return string
     */
    public function getClosedAt(): string
    {
        return Carbon::parse($this->closed_at)->format('d-m-Y');
    }

    /**
     * get created at
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }
}
