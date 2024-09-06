<?php

namespace App\Repositories\Game2048;

use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Game2048RepositoryInterface;

class game2048Repository extends BaseRepository implements Game2048RepositoryInterface
{
    protected $model;
    protected $modelUser;
    protected $modelLog;
    protected $modelQuestLog;

    public function __construct()
    {
    }

    //get model
    public function getModel()
    {
        return $this->model;
    }

    // set model
    public function addModel($modelData)
    {
        $this->model = $modelData;
    }

    // set model user
    public function addModelUser($modelUser)
    {
        $this->modelUser = $modelUser;
    }

    // set model log
    public function addModelLog($modelLog)
    {
        $this->modelLog = $modelLog;
    }

    // set model log
    public function addModelQuestLog($modelQuestLog)
    {
        $this->modelQuestLog = $modelQuestLog;
    }

    public function updateUser($id, array $params){
        $user = $this->modelUser->find($id);

        if ($user) {
            return $user->update($params);
        }

        return false;
    }

    public function createLog(array $attributes){
        return $this->modelLog->create($attributes);
    }

    public function createQuestLog(array $attributes){
        return $this->modelQuestLog->create($attributes);
    }
}