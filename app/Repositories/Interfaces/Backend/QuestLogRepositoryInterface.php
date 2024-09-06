<?php

namespace App\Repositories\Interfaces\Backend;

use App\Repositories\RepositoryInterface;

interface QuestLogRepositoryInterface extends RepositoryInterface
{
    public function addModel( $model );
    public function getById( $id );
    public function addQuestLog( $userId, $dateNumber, $questId );
}