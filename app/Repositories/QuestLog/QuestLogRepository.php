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

    public function addQuestLog($userId, $dateNumber, $questId, $data = []): void
    {
        $quest = $this->helpers->findQuestById($questId);
        $data = [
            'user_id' => $userId,
            'quest_id' => $questId,
            'date_number' => $dateNumber
        ];

        if ($quest['id'] === 1 || $quest['id'] === 9) { // 1:Đăng ký đi chơi công viên(1/1) || 9:Ghé thăm Thố Động mỗi ngày
            $data['is_done'] = true;
        }

        $this->model->query()->create($data);
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