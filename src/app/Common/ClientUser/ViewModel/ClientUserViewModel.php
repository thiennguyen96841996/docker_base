<?php

namespace App\Common\ClientUser\ViewModel;

use App\Common\Database\MysqlCryptorTrait;
use App\Common\View\Contract\ViewModel as ViewModelContract;
use App\Common\View\ViewModelable;

class ClientUserViewModel implements ViewModelContract
{
    use ViewModelable, MysqlCryptorTrait;

    /**
     * 氏名を取得
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->decrypt($this->name);
    }

    /**
     * 電話を取得
     *
     * @return string
     */
    public function getTel(): string
    {
        return $this->decrypt($this->tel);
    }
}
