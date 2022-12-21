<?php
namespace App\Common\Csv\Contract;

use Illuminate\Database\Eloquent\Builder;

interface CsvViewModel
{
    public function setBuilder(Builder $builder);

    public function getBuilder();

    public function convert($data);

    public function getHeader();
}
