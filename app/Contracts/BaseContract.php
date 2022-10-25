<?php

namespace App\Contracts;

interface BaseContract
{
    public function getQuery();

    public function factory();

    public function getDbQuery();

    public function with(string|array $relation);

    public function first();

    public function find(int|string $id, bool $withTrash = false);

    public function findByIdOrFail(int|string $id);

    public function where(array $params, bool $first = false);

    public function create(array $request);
}
