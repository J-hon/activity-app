<?php

namespace App\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface RevisionContract extends BaseContract
{

    public function getUserActivitiesByDateRange(int $userId, $startDate, $endDate): LengthAwarePaginator;

}
