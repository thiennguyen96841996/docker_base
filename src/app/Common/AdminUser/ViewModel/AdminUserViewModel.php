<?php

namespace App\Common\AdminUser\ViewModel;

use App\Common\View\Contract\ViewModel as ViewModelContract;
use App\Common\View\ViewModelable;
use App\Common\Database\MysqlCryptorTrait;

/**
 * @property mixed $name
 * @property mixed $tel
 * @property mixed $email
 * @property mixed $avatar
 */
class AdminUserViewModel implements ViewModelContract
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
     * 氏名を取得
     *
     * @return string
     */
    public function getTel(): string
    {
        return $this->decrypt($this->tel);
    }

    /**
     * 氏名を取得
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->decrypt($this->email);
    }

    /**
     * 氏名を取得
     *
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->decrypt($this->avatar);
    }
}
