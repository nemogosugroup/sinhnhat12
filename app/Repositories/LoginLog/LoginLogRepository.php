<?php

namespace App\Repositories\LoginLog;

use App\Helpers\Helpers;
use App\Models\LoginLog;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Backend\LoginLogRepositoryInterface;

class LoginLogRepository extends BaseRepository implements LoginLogRepositoryInterface
{
    protected $model;
    protected $helpers;

    public function __construct(Helpers $helpers, LoginLog $loginLog)
    {
        $this->helpers = $helpers;
        $this->model = $loginLog;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function addModel($modelData)
    {
        $this->model = $modelData;
    }

    public function getById($id)
    {
        $data = $this->model->find($id);

        return $data->toArray();
    }

    public function handleSaveLog($userId, $dateNumber): bool
    {
        $exists = $this->model->query()->where([
            'user_id' => $userId,
            'date_number' => $dateNumber
        ])->exists();

        if (!$exists && $dateNumber > 0) {
            $this->model->query()->create([
                'user_id' => $userId,
                'date_number' => $dateNumber,
                'code' => $this->helpers->generateCodeQuest2($userId, $dateNumber)
            ]);

            return true;
        }

        return false;
    }
}