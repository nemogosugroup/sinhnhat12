<?php

namespace App\Repositories\Interfaces\Backend;

use App\Repositories\RepositoryInterface;

interface LoginLogRepositoryInterface extends RepositoryInterface
{
    public function addModel( $model );
    public function getById( $id );
    public function handleSaveLog( $userId, $dateNumber );
}