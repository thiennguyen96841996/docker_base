<?php

namespace App\Common\AgencyContract\ViewModel;

use App\Common\AgencyContract\Definition\AgencyContract;
use App\Common\View\Contract\ViewModel as ViewModelContract;
use App\Common\View\ViewModelable;
use Carbon\Carbon;

class AgencyContractViewModel implements ViewModelContract
{
    use ViewModelable;

    /**
     * @return string
     */
    public function getEndDate() :string
    {
        return !empty($this->end_date) ? Carbon::parse($this->end_date)->format('d-m-Y') : AgencyContract::getName(AgencyContract::UN_LIMIT->value);
    }
}
