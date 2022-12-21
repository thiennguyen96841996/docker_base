<?php
namespace App\Common\Agency\Contract;

use App\Common\Agency\ViewModel\AgencyViewModel;
use App\Common\Csv\AbsCsvViewModel;
use App\Common\Repository\ViewModelRepositoryTrait;


abstract class AgencyCsvViewModel extends AbsCsvViewModel
{
    use ViewModelRepositoryTrait;

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->setViewModel(new AgencyViewModel());
    }
}

