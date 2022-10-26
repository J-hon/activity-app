<?php

namespace App\Contracts;

interface BaseContract
{

    public function getQuery();

    public function all();

    public function find(int|string $id, bool $withTrash = false);

    public function updateBy(array $where, array $request);

    public function create(array $request);

    public function update(int|string $id, array $request, bool $returnModel = true, bool $withTrash = false);

    public function delete(int|string $id): bool;

}
