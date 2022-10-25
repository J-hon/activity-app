<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\User;

class UserRepository extends BaseRepository implements UserContract
{

    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function addToMovieList(int $userId, int $movieId): array
    {
        return $this->find($userId)->movies()->syncWithoutDetaching($movieId);
    }

    public function removeFromMovieList(int $userId, int $movieId): int
    {
        return $this->find($userId)->movies()->detach($movieId);
    }

}
