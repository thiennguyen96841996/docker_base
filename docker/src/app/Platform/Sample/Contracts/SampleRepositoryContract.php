<?php

namespace GLC\Platform\Sample\Contracts;

use GLC\Platform\Repository\Contracts\ViewModelRepository;

interface SampleRepositoryContract extends ViewModelRepository
{
    public function getFugafuga(array $arg);
}