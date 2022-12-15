<?php

namespace App\Common\Project\ViewModel;

use App\Common\Database\MysqlCryptorTrait;
use App\Common\View\Contract\ViewModel as ViewModelContract;
use App\Common\View\ViewModelable;
use Carbon\Carbon;

class ProjectViewModel implements ViewModelContract
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
}
