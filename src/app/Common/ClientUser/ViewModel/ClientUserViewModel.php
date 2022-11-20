<?php

namespace App\Common\ClientUser\ViewModel;

use Carbon\Carbon;
use App\Common\View\ViewModelable;
use App\Common\Database\MysqlCryptorTrait;
use App\Common\View\Contract\ViewModel as ViewModelContract;

class ClientUserViewModel implements ViewModelContract
{
    use ViewModelable, MysqlCryptorTrait;

    /**
     * get client's name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->decrypt($this->name);
    }

    /**
     * get client's tel
     *
     * @return string
     */
    public function getTel(): string
    {
        return $this->decrypt($this->tel);
    
    }

    /**
     * get client's avatar
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar ? $this->decrypt($this->avatar) : '';
    }

    /**
     * get client's hotline
     *
     * @return string
     */
    public function getHotline(): string
    {
        return $this->decrypt($this->hotline);
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
