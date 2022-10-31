<?php

namespace App\Contracts;

interface UserContract extends BaseContract
{

    public function addToMovieList(int $userId, int $movieId): array;

    public function removeFromMovieList(int $userId, int $movieId): int;

}
