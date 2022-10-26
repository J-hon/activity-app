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

    public function all()
    {
        return $this->getQuery()->get();
    }

    public function count()
    {
        return $this->getQuery()->count();
    }

    public function paginate(int $limit = 10)
    {
        return $this->getQuery()->paginate($limit);
    }

    public function paginateWhere(array $params, int $limit = 10)
    {
        return $this->getQuery()->where($params)->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function find(int|string $id, $withTrash = false)
    {
        if ($withTrash) {
            return $this->getQuery()->withTrashed()->find($id);
        }

        return $this->getQuery()->find($id);
    }

    public function updateBy(array $where, array $request)
    {
        return $this->getQuery()->where($where)->update($request);
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

    public function insert(array $rows)
    {
        return $this->getQuery()->insert($rows);
    }

    public function with(string|array $relation)
    {
        return $this->getQuery()->with($relation);
    }

    public function update(int|string $id, array $request, bool $returnModel = true, bool $withTrash = false)
    {
        if ($withTrash) {
            $model = $this->getQuery()->withTrashed()->find($id);
        } else {
            $model = $this->getQuery()->find($id);
        }

        $successful = $model->update($request);

        return $returnModel ? $model : $successful;
    }

    public function deleteBy(array $where): bool
    {
        return $this->getQuery()->where($where)->delete();
    }

    public function delete(int|string $id): bool
    {
        return $this->getQuery()->find($id)->delete();
    }
}
