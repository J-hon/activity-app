<?php

namespace App\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface RevisionContract extends BaseContract
{

    public function getByDateRange($startDate, $endDate): LengthAwarePaginator;

}
