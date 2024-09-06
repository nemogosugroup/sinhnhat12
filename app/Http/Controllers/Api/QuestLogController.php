<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\QuestLog\QuestLogRepository;
use App\Helpers\Message;
use App\Helpers\Helpers;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class QuestLogController extends Controller
{
    protected $userRepo;
    protected $questLogRepo;
    protected $msg;
    protected $helpers;

    public function __construct(
        UserRepository     $userRepository,
        QuestLogRepository $questLogRepository,
        Message            $message,
        Helpers            $helpers
    )
    {
        $this->userRepo = $userRepository;
        $this->questLogRepo = $questLogRepository;
        $this->msg = $message;
        $this->helpers = $helpers;
    }

    public function handleUpdateQuest(Request $request)
    {
        dd($request->all());
    }

    public function handleReceiveQuestReward(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $questId = $request->input('quest_id');

            // check+get quest by $questId
            $questData = $this->helpers->findQuestById($questId);
            if (count($questData) === 0) {
                $results = array(
                    'message' => $this->msg->questNotExists(),
                    'success' => false,
                    'status' => ResponseAlias::HTTP_OK
                );
                return response()->json($results);
            }

            // check quest completed by quest_logs.is_done = 1
            //$isDone = $this->questLogRepo->checkQuestIsDone(auth()->user()->id, $questId);
            $isDone = $this->questLogRepo->checkQuestIsDone(1, $questId);
            if ($isDone) {
                // TODO: handle update data log case: receive quest's reward (+mochi)
                // TODO: waiting for new code use to update data_logs from Mr.Phe
            } else {
                $results = array(
                    'message' => $this->msg->questNotComplete(),
                    'success' => false,
                    'status' => ResponseAlias::HTTP_OK
                );
                return response()->json($results);
            }

            $results = array(
                'message' => $this->msg->receiveQuestRewardSuccess(),
                'success' => true,
                'status' => ResponseAlias::HTTP_OK
            );
            return response()->json($results);
        } catch (\Throwable $th) {
            $results = array(
                'message' => $th->getMessage(),
                'success' => false,
                'status' => ResponseAlias::HTTP_OK
            );
            return response()->json($results);
        }
    }
}
