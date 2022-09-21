<?php

namespace GLC\Platform\Sample\ViewModels;

use Illuminate\Database\Eloquent\Model;
use GLC\Platform\View\Contracts\ViewModel as ViewModelContract;
use GLC\Platform\View\ViewModelable;

class SampleViewModel implements ViewModelContract
{
    use ViewModelable;
}