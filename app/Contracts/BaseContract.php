<?php

namespace App\Contracts;

interface BaseContract
{
    public function getQuery();

    public function factory();

    public function getDbQuery();

    public function first();

    public function all();

    public function count();

    public function paginate(int $limit = 10);

    public function paginateWhere(array $params, int $limit = 10);

    public function find(int|string $id, bool $withTrash = false);

    public function updateBy(array $where, array $request);

    public function findByIdOrFail(int|string $id);

    public function where(array $params, bool $first = false);

    public function create(array $request);

    public function insert(array $rows);

    public function with(string|array $relation);

    public function update(int|string $id, array $request, bool $returnModel = true, bool $withTrash = false);

    public function delete(int|string $id): bool;

    public function deleteBy(array $where): bool;
}
