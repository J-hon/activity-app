<?php

namespace App\Repositories;

use App\Contracts\ActivityContract;
use App\Models\Activity;

class ActivityRepository extends BaseRepository implements ActivityContract
{

    public function __construct(Activity $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

}
