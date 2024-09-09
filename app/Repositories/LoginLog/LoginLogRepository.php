<?php

namespace App\Repositories\LoginLog;

use App\Helpers\Helpers;
use App\Helpers\Message;
use App\Models\LoginLog;
use App\Models\QuestLog;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Backend\LoginLogRepositoryInterface;

class LoginLogRepository extends BaseRepository implements LoginLogRepositoryInterface
{
    protected $model;
    protected $questLogModel;
    protected $helpers;
    protected $msg;

    public function __construct(Helpers $helpers, LoginLog $loginLog, QuestLog $questLog, Message $message)
    {
        $this->model = $loginLog;
        $this->questLogModel = $questLog;
        $this->helpers = $helpers;
        $this->msg = $message;
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

    public function getCodeInvite($userId): string
    {
        $result = $this->model->query()
            ->where([
                'user_id' => $userId,
                'date_number' => $this->helpers->getCurrentDateNumber()
            ])->first();

        return !empty($result) ? $result->code : '';
    }

    public function validateCode(string $code): array
    {
        $currentDateNumber = $this->helpers->getCurrentDateNumber();

        // check code exists with current date
        $codeData = $this->model->query()->where([
            'date_number' => $currentDateNumber,
            'code' => $code
        ])->first();
        if (!$codeData) {
            return [
                'value' => false,
                'message' => $this->msg->inviteCodeInvalid($code)
            ];
        }

        // check code duplicated
        $isUsed = $this->questLogModel->query()->where([
            'user_id' => auth()->user()->id,
            'date_number' => $currentDateNumber,
            'code' => $code
        ])->exists();
        if ($isUsed) {
            return [
                'value' => false,
                'message' => $this->msg->inviteCodeUsed($code)
            ];
        }

        // count+check code in quest_logs is not >= 10 times
        $countCodeUsed = $this->questLogModel->query()->where([
            'date_number' => $currentDateNumber,
            'code' => $code
        ])->count();
        if ($countCodeUsed >= 10) {
            return [
                'value' => false,
                'message' => $this->msg->inviteCodeExpired($code)
            ];
        }

        // count+check is user have done quest 3
        $countQuest3 = $this->questLogModel->query()->where([
            'date_number' => $currentDateNumber,
            'user_id' => auth()->user()->id,
            'quest_id' => 3
        ])->count();
        if ($countQuest3 >= 10) {
            return [
                'value' => false,
                'message' => $this->msg->inviteMaxQuest3()
            ];
        }

        return [
            'value' => true,
            'code_owner' => $codeData['user_id']
        ];
    }
}