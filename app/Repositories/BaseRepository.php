<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;

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

    public function all()
    {
        return $this->getQuery()->get();
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

    public function create(array $request)
    {
        return $this->getQuery()->create($request);
    }

    public function where(array $params, bool $first = false)
    {
        $query = $this->getQuery()->where($params);

        return $first ? $query->first() : $query->get();
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

    public function delete(int|string $id): bool
    {
        return $this->getQuery()->find($id)->delete();
    }
}
