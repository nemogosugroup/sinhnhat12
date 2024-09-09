<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataLog;
use App\Models\User;
use App\Repositories\QuestLog\QuestLogRepository;
use App\Repositories\LoginLog\LoginLogRepository;
use App\Repositories\Game2048\game2048Repository as DataLogRepository;
use App\Helpers\Message;
use App\Helpers\Helpers;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class QuestLogController extends Controller
{
    protected $loginLogRepo;
    protected $questLogRepo;
    protected $dataLogRepo;
    protected $msg;
    protected $helpers;

    public function __construct(
        LoginLogRepository $loginLogRepository,
        QuestLogRepository $questLogRepository,
        DataLogRepository  $dataLogRepo,
        Message            $message,
        Helpers            $helpers,
        DataLog            $modelLog,
        User               $modelUser
    )
    {
        $this->loginLogRepo = $loginLogRepository;
        $this->questLogRepo = $questLogRepository;
        $this->dataLogRepo = $dataLogRepo;
        $this->dataLogRepo->addModelLog($modelLog);
        $this->dataLogRepo->addModelUser($modelUser);
        $this->msg = $message;
        $this->helpers = $helpers;
    }

    public function handleReceiveQuestReward(int $questId): \Illuminate\Http\JsonResponse
    {
        try {
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

            // check quest completed by quest_logs.is_done = 1 && quest_logs.is_received = 0
            $isDone = $this->questLogRepo->checkQuestIsDone(auth()->user()->id, $questId);
            if ($isDone) {
                // handle update data_logs case: receive quest's reward (+mochi)
                $data = [
                    'type' => EVENT_BIRTHDAY12['type']['mochi'],
                    'points' => $questData['mochi'],
                    'name_quest' => $questData['desc']
                ];
                $data = $this->helpers->convertDataLog($data);
                $dataLog = $this->dataLogRepo->createLog($data);

                // update quest_logs.is_received
                $this->questLogRepo->updateIsReceived(auth()->user()->id, $questId);

                // update users.point_mochi
                $dataUser = [
                    'point_mochi' => auth()->user()->point_mochi + $dataLog['points']
                ];
                $this->dataLogRepo->updateUser(auth()->user()->id, $dataUser);

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

    public function handleInviteCode(string $code): \Illuminate\Http\JsonResponse
    {
        try {
            // check code with current date
            $codeValid = $this->loginLogRepo->validateCode($code);
            if (!$codeValid['value']) {
                $results = array(
                    'message' => $codeValid['message'],
                    'success' => false,
                    'status' => ResponseAlias::HTTP_OK
                );
                return response()->json($results);
            }

            // add quest_logs for receiver + owner code
            $dateNumber = $this->helpers->getCurrentDateNumber();
                // add quest for code's owner
            $this->questLogRepo->addQuestLog($codeValid['code_owner'], $dateNumber, 2);
                // add quest for code's receiver
            $this->questLogRepo->addQuestLog(auth()->user()->id, $dateNumber, 3, $code);

            $questsDone = $this->helpers->countQuestIsFinishAll($dateNumber);
            if(count($questsDone) === 9) {
                $this->questLogRepo->addQuestLog($codeValid['code_owner'], $dateNumber, 10);
            }

            $results = array(
                'message' => $this->msg->inviteCodeSuccess(),
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
