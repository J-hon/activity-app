<?php

namespace App\Repositories;

use App\Contracts\RevisionContract;
use App\Models\Revision;
use Illuminate\Pagination\LengthAwarePaginator;

class RevisionRepository extends BaseRepository implements RevisionContract
{

    public function __construct(Revision $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getUserActivitiesByDateRange(int $userId, $startDate, $endDate): LengthAwarePaginator
    {
        return $this->getQuery()
            ->where('user_id', '=', $userId)
            ->whereHas('activity', function($query) use ($startDate, $endDate) {
                $query->whereBetween('due_date', [$startDate, $endDate]);
            })
            ->paginate(10);
    }

}
