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
            ->whereBetween('created_at', [$startDate, $endDate])
            ->paginate(10);
    }

}
