<?php

namespace App\Repositories\Interfaces;

//use App\Repositories\RepositoryInterface;

interface Game2048RepositoryInterface
{
    public function updateUser($id, array $params);
    public function createLog(array $params);
}