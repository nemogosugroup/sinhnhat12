<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\Message;
use App\Helpers\Helpers;
use App\Repositories\Interfaces\Game2048RepositoryInterface;
use App\Models\ScoreLog;
use App\Models\User;
use App\Models\DataLog;

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
        DataLog $modelLog
    )
    {
        $this->repo = $repo;
        $this->msg = $message;
        $this->helper = $helper;
        $this->repo->addModel($model);
        $this->repo->addModelUser($modelUser);
        $this->repo->addModelLog($modelLog);

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
        $params = $request->all();
        $data = $this->repo->create($params);

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

        $dataLog = $params;
        $dataLog['type'] = EVENT_BIRTHDAY12['type']['silk'];
        $dataLog['points'] = $params['point_silk'];

        $dataLogSilk = $this->helper->convertDataLog( $dataLog );
        $dataLogMochi = $this->helper->convertDataLog([]);

        $this->repo->createLog($dataLogSilk);
        $this->repo->createLog($dataLogMochi);

        $results = array(
            'success' => true,
            'data' => $data,
            'message' => $this->msg->createSuccess(),
            'status' => Response::HTTP_OK
        );
        return response()->json($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLog(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}