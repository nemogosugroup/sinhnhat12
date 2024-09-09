<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\Message;
use App\Helpers\Helpers;
use App\Repositories\Interfaces\Game2048RepositoryInterface;
use App\Models\ScoreLog;
use App\Models\User;
use App\Models\DataLog;
use App\Models\QuestLog;
use phpseclib3\Crypt\AES;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ScoreController extends Controller
{
    /**
     * @var PostRepositoryInterface
     */
    protected $repo;
    protected $msg;
    protected $helper;

    public function __construct(
        Game2048RepositoryInterface $repo,
        Message $message,
        Helpers $helper,
        ScoreLog $model,
        User $modelUser,
        DataLog $modelLog,
        QuestLog $modelQuestLog
    )
    {
        $this->repo = $repo;
        $this->msg = $message;
        $this->helper = $helper;
        $this->repo->addModel($model);
        $this->repo->addModelUser($modelUser);
        $this->repo->addModelLog($modelLog);
        $this->repo->addModelQuestLog($modelQuestLog);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $encryptedData = $request->input('data');
        $iv = $request->input('iv');
        $aes = new AES('cbc');
        $aes->setKey(EVENT_BIRTHDAY12['secretKey']);
        $aes->setIV($iv);
        $decryptedData = $aes->decrypt(base64_decode($encryptedData));
        $dataJson = json_decode($decryptedData, true);
        //$params = $request->all();
        $params = $dataJson;
        $data = $this->repo->create($params);
        // update kimto/mochi/bestcore/is_lucky for user
        $dataUser = array(
            'point_silk' => auth()->user()->point_silk + $params['point_silk'],
            'point_mochi' => auth()->user()->point_mochi - EVENT_BIRTHDAY12['mochi']
        );
        if($data['scores'] > auth()->user()->score){
            $dataUser['score'] = $data['scores'];
        }

        $isLucky = User::where('is_lucky','=', 1);
        if($isLucky->count() == 0){
            $totalSilk = $this->helper->getotalPointSilk();
            $totalSilk = $totalSilk + $data['silk'];
            if($totalSilk >= EVENT_BIRTHDAY12['point_lucky']){
                $dataUser['is_lucky'] = 1;
            }
        }
        $this->repo->updateUser(auth()->user()->id, $dataUser);

        // create data logs
        $dataLog = $params;
        $dataLog['type'] = EVENT_BIRTHDAY12['type']['silk'];
        $dataLog['points'] = $params['point_silk'];
        $dataLogSilk = $this->helper->convertDataLog( $dataLog );
        $dataLogMochi = $this->helper->convertDataLog([]);
        $this->repo->createLog($dataLogSilk);
        $this->repo->createLog($dataLogMochi);

        // create quest log
        $this->helper->checkQuestForCurrentDate($data['scores']);

        $results = array(
            'success' => true,
            'data' => 'Hello GOSU 2024',
            'message' => $this->msg->createSuccess(),
            'status' => Response::HTTP_OK
        );
        return response()->json($results);
    }

    public function getRanksList(): \Illuminate\Http\JsonResponse
    {
        try {
            $ranks = app(UserRepository::class)->getRanksList();
            $results = array(
                'success' => true,
                'ranks' => $ranks,
                'message' => $this->msg->getSuccess(),
                'status' => ResponseAlias::HTTP_OK
            );
            return response()->json($results);

        } catch (\Throwable $th) {
            $results = array(
                'message' => $th->getMessage(),
                'success' => false,
                'status' => ResponseAlias::HTTP_OK
            );
            return response()->json([$results], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function getLogsList(): \Illuminate\Http\JsonResponse
    {
        try {
            $logs = app(UserRepository::class)->getLogsList();
            $results = array(
                'success' => true,
                'logs' => $logs,
                'message' => $this->msg->getSuccess(),
                'status' => ResponseAlias::HTTP_OK
            );
            return response()->json($results);

        } catch (\Throwable $th) {
            $results = array(
                'message' => $th->getMessage(),
                'success' => false,
                'status' => ResponseAlias::HTTP_OK
            );
            return response()->json([$results], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function setFirstTimeToFalse(): \Illuminate\Http\JsonResponse
    {
        try {
            app(UserRepository::class)->setFirstTimeToFalse();
            $results = array(
                'success' => true,
                'message' => $this->msg->getSuccess(),
                'status' => ResponseAlias::HTTP_OK
            );
            return response()->json($results);

        } catch (\Throwable $th) {
            $results = array(
                'message' => $th->getMessage(),
                'success' => false,
                'status' => ResponseAlias::HTTP_OK
            );
            return response()->json([$results], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}