<?php

namespace App\Repositories\QuestLog;

use App\Helpers\Helpers;
use App\Models\QuestLog;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Backend\QuestLogRepositoryInterface;

class QuestLogRepository extends BaseRepository implements QuestLogRepositoryInterface
{
    protected $model;
    protected $helpers;

    public function __construct(QuestLog $questLog, Helpers $helpers)
    {
        $this->model = $questLog;
        $this->helpers = $helpers;
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

    public function addQuestLog($userId, $dateNumber, $questId, $code = ''): void
    {
        $quest = $this->helpers->findQuestById($questId);
        $data = [
            'user_id' => $userId,
            'quest_id' => $questId,
            'date_number' => $dateNumber
        ];

        if (
            $quest['id'] === 1 || // 1:Đăng ký đi chơi công viên(1/1)
            $quest['id'] === 9 || // 9:Ghé thăm Thố Động mỗi ngày
            $quest['id'] === 6 || // 6:Thu thập được 15 Kim Tơ/ngày
            $quest['id'] === 7 || // 7:Thu thập được 50 Kim Tơ/ngày
            $quest['id'] === 10   // 10:Hoàn thành các nhiệm vụ mỗi ngày
        ) {
            $data['is_done'] = true;
        }

        if ($quest['id'] === 2 || $quest['id'] === 3) { // 2:Rủ 10 người(10/10) || 3:Được 10 người rủ(10/10)
            $data['code'] = $quest['id'] === 3 ? $code : null;
            $isLastQuest = $this->checkIsLastCodeQuest($userId, $questId, $dateNumber);
            if ($isLastQuest) {
                $data['is_done'] = true;
            }
        }

        $this->model->query()->create($data);

        if ($quest['id'] === 2 || $quest['id'] === 3) { // 2:Rủ 10 người(10/10) || 3:Được 10 người rủ(10/10)
            $this->checkAndUpdateFinalQuest($userId, $dateNumber);
        }
    }

    private function checkAndUpdateFinalQuest($userId, $dateNumber)
    {
        $countAll = $this->model->query()->where([
            'user_id' => $userId,
            'date_number' => $dateNumber,
            'is_done' => true
        ])->count();
        if ($countAll === 9) {
            $this->addQuestLog($userId, $dateNumber, 10);
        }
    }

    private function checkIsLastCodeQuest($userId, $questId, $dateNumber): bool
    {
        $count = $this->model->query()->where([
            'user_id' => $userId,
            'quest_id' => $questId,
            'date_number' => $dateNumber
        ])->count();

        return $count === 9;
    }

    public function updateIsReceived($userId, $questId)
    {
        $this->model->query()->where([
            'user_id' => $userId,
            'quest_id' => $questId,
            'date_number' => $this->helpers->getCurrentDateNumber(),
            'is_done' => true,
            'is_received' => false
        ])->update([
            'is_received' => true
        ]);
    }

    public function checkQuestIsDone($userId, $questId): bool
    {
        return $this->model->query()->where([
            'user_id' => $userId,
            'quest_id' => $questId,
            'date_number' => $this->helpers->getCurrentDateNumber(),
            'is_done' => true,
            'is_received' => false
        ])->exists();
    }

    public function getIsDoneIsReceivedValues($userId, $questId, $dateNumber): array
    {
        $result = $this->model->query()->select('is_done', 'is_received')
            ->where([
                'user_id' => $userId,
                'quest_id' => $questId,
                'date_number' => $dateNumber,
                'is_done' => true
            ])->first();

        return !empty($result) ? $result->toArray() : ['is_done' => 0, 'is_received' => 0];
    }

    public function getProgressCurrentValue($userId, $questId, $dateNumber): int
    {
        return $this->model->query()->where([
            'user_id' => $userId,
            'quest_id' => $questId,
            'date_number' => $dateNumber
        ])->count();
    }
}