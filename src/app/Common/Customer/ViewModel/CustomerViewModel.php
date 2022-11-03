<?php

namespace App\Common\Customer\ViewModel;

use App\Common\Database\MysqlCryptorTrait;
use App\Common\View\Contract\ViewModel as ViewModelContract;
use App\Common\View\ViewModelable;

class CustomerViewModel implements ViewModelContract
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

    /**
     * 生年月日を取得
     *
     * @return string
     */
    public function getBirthday(): string
    {
        return $this->decrypt($this->birthday);
    }

    /**
     * 住所を取得
     *
     * @return string
     */
    public function getAddress(): string
    {
        return $this->decrypt($this->address);
    }

    /**
     * 性別を取得
     *
     * @return string
     */
    public function getGender(): string
    {
        if (is_null($this->gender)) {
            return '';
        } else {
            return $this->decrypt($this->gender);
        }
    }
}
