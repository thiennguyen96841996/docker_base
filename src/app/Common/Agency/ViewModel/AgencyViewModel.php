<?php

namespace App\Common\Agency\ViewModel;

use App\Common\Agency\Definition\AgencyStatus;
use App\Common\View\Contract\ViewModel as ViewModelContract;
use App\Common\View\ViewModelable;
use Carbon\Carbon;

class AgencyViewModel implements ViewModelContract
{
    use ViewModelable;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return AgencyStatus::getName($this->status);
    }

    /**
     * @return string
     */
    public function getEstablishmentDate(): string
    {
        return Carbon::parse($this->establishment_date)->format('d/m/Y');
    }
}
