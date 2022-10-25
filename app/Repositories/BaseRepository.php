<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseRepository implements BaseContract
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getQuery()
    {
        return $this->model->query();
    }

    public function factory(): Factory
    {
        return $this->model::factory();
    }

    public function getDbQuery()
    {
        return DB::connection($this->model->getConnectionName())->table($this->model->getTable());
    }

    public function first()
    {
        return $this->getQuery()->first();
    }

    public function with(string|array $relation)
    {
        return $this->getQuery()->with($relation);
    }

    public function find(int|string $id, $withTrash = false)
    {
        if ($withTrash) {
            return $this->getQuery()->withTrashed()->find($id);
        }

        return $this->getQuery()->find($id);
    }

    public function findByIdOrFail(int|string $id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    public function where(array $params, bool $first = false)
    {
        $query = $this->getQuery()->where($params);

        return $first ? $query->first() : $query->get();
    }

    public function create(array $request)
    {
        return $this->getQuery()->create($request);
    }
}
