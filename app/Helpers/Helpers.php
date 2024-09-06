<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Http\Response;
use App\Helpers\Message;
use App\Models\User;
use App\Models\QuestLog;
use App\Models\DataLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Helpers
{
    protected $msg;
    protected $modelUser;
    protected $modelQuestLog;
    protected $modelDataLog;
    protected $ldapHost;

    public function __construct(
        Message  $message,
        User     $modelUser,
        QuestLog $modelQuestLog,
        DataLog  $modelDataLog
    )
    {
        $this->msg = $message;
        $this->ldapHost = env("LDAP_HOST", "222.255.168.250");
        $this->modelUser = $modelUser;
        $this->modelQuestLog = $modelQuestLog;
        $this->modelDataLog = $modelDataLog;
    }

    public function bindldap($email, $pass)
    {
        $ldaprdn = str_replace("@gosu.vn", "", $email) . "@gosu.vn";
        $ldappass = $pass;

        $ldapconn = ldap_connect($this->ldapHost) or die("Could not connect to LDAP server.");

        if ($ldapconn) {
            try {
                // Đặt các tùy chọn LDAP
                ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

                // Xác thực với tên người dùng và mật khẩu LDAP
                $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

                // Kiểm tra xem người dùng có xác thực thành công hay không
                ldap_close($ldapconn);

                return $ldapbind === true;
            } catch (\Exception $e) {
                ldap_close($ldapconn);
                return false;
            }
        }

        return false;
    }

    public function getSlug($title, $model)
    {
        $slug = Str::slug($title);
        $slugCount = count($model->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());
        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }

    public function convertArrayByLocale(array $data, string $locale): array
    {
        foreach ($data as $idx => $item) {
            // category
            $category = $item['category'];
            unset($data[$idx]['category']['translations']);
            $newCategory = array_filter($category['translations'], function ($cat) use ($locale) {
                return $cat['locale'] === $locale;
            });

            // post
            $postTrans = $item['translations'];
            unset($data[$idx]['translations']);
            $newPost = array_filter($postTrans, function ($post) use ($locale) {
                return $post['locale'] === $locale;
            });

            // merge
            $newPost = reset($newPost);
            $data[$idx]['title'] = $newPost['title'];
            $data[$idx]['description'] = $newPost['description'];
            $data[$idx]['content'] = $newPost['content'];

            $newCategory = reset($newCategory);
            $data[$idx]['category']['title'] = $newCategory['title'];
        }

        return $data;
    }

    public function convertSingleByLocale(array $data, string $locale): array
    {
        if (!empty($data)) {
            // category
            $category = $data['category'];
            unset($data['category']['translations']);
            $newCategory = array_filter($category['translations'], function ($cat) use ($locale) {
                return $cat['locale'] === $locale;
            });

            // post
            $postTrans = $data['translations'];
            unset($data['translations']);
            $newPost = array_filter($postTrans, function ($post) use ($locale) {
                return $post['locale'] === $locale;
            });

            // merge
            $newPost = reset($newPost);
            $data['title'] = $newPost['title'];
            $data['description'] = $newPost['description'];
            $data['content'] = $newPost['content'];

            $newCategory = reset($newCategory);
            $data['category']['title'] = $newCategory['title'];

        }

        return $data;
    }

    public function getCurrentDateNumber(): int
    {
        $arrDates = [
            8 => Carbon::now()->format('d/m/Y'), // just for TEST
            1 => '18/09/2024',
            2 => '19/09/2024',
            3 => '20/09/2024',
            4 => '21/09/2024'
        ];
        $currentDate = Carbon::now()->format('d/m/Y');
        $key = array_search($currentDate, $arrDates);

        return $key ?? 0;
    }

    public function findQuestById($questId): array
    {
        $foundQuest = array_filter(QUEST_TMP, function ($quest) use ($questId) {
            return $quest['id'] === $questId;
        });

        return count($foundQuest) > 0 ? reset($foundQuest) : [];
    }

    public function generateCodeQuest2($userId, $dateNumber): string
    {
        $randomString = strtoupper(Str::random(10));

        return $randomString . $userId . $dateNumber;
    }

    public function getotalPointSilk()
    {
        return User::sum('point_silk');
    }

    public function convertDataLog(array $arr)
    {
        $results = [
            'type' => EVENT_BIRTHDAY12['type']['mochi'],
            'action' => EVENT_BIRTHDAY12['action']['minus'],
            'points' => EVENT_BIRTHDAY12['mochi'],
            'content' => sprintf('Bạn đã sử dụng %d mochi để chơi Vòng Xoay Mặt Trời', EVENT_BIRTHDAY12['mochi']),
        ];
        if (count($arr) > 0) {
            if ($arr['type'] == EVENT_BIRTHDAY12['type']['silk']) {
                $results = $arr;
                $results['action'] = EVENT_BIRTHDAY12['action']['plus'];
                $results['content'] = sprintf('Nhận được %d Kim Tơ ở Vòng Xoay Mặt Trời', $arr['points']);
                $results['points'] = $arr['points'];
            }
            if ($arr['type'] == EVENT_BIRTHDAY12['type']['mochi']) {
                $results['action'] = EVENT_BIRTHDAY12['action']['plus'];
                $results['content'] = sprintf('Nhận được trong nhiệm vụ " %d "', $arr['name_quest']);
                $results['points'] = $arr['points'];
            }
        }
        $results['user_id'] = auth()->user()->id;
        return $results;
    }

    public function checkQuestForCurrentDate(int $points){

        // $points => point score
        // + Tham gia trò chơi Vòng Xoay Mặt Trời 5 lần/ngày (5/5) - 10 Mochi => id nhiệm vụ là 4
        // + Lần đầu nhận được Kim Tơ trong ngày (1/1) - 5 Mochi  => id nhiệm vụ là 5
        // + Thu thập được 15 Kim Tơ/ngày (15/15) - 15 Mochi  => id nhiệm vụ là 6
        // + Thu thập được 50 Kim Tơ/ngày (50/50) - 15 Mochi   => id nhiệm vụ là 7
        // + Ghi được 1500 điểm trong một lượt chơi tại Vòng Xoay Mặt Trời - 10 Mochi  => id nhiệm vụ là 8
        // + Hoàn thành các nhiệm vụ trên mỗi ngày (1/1) - 15 Mochi => id nhiệm vụ là 10
        if($points > 0){
            $date_number = $this->getCurrentDateNumber();
            $existsInGame = $this->checkQuestIsDoneForGame(4 ,$date_number);
            if(count($existsInGame) == 0){
                $_existsInGame = $this->checkQuestIsDoneForGame(4 ,$date_number, 0);
                if(count($_existsInGame) == 4){
                    $this->createQuestForGame(4 ,$date_number);
                }else{
                    $this->createQuestForGame(4 ,$date_number, 0);
                }
            }
            $existsAddSilk = $this->checkQuestIsDoneForGame(5 ,$date_number);
            if(count($existsAddSilk) == 0){
                $this->createQuestForGame(5 ,$date_number);
            }

            if($points >= 1500){
                $existsAdd1500Point = $this->checkQuestIsDoneForGame(8 ,$date_number);
                if(count($existsAdd1500Point) == 0){
                    $this->createQuestForGame(8 ,$date_number);
                }
            }

            if($points >= 2000){
                $existsAdd2000Point = $this->checkQuestIsDoneForGame(6 ,$date_number);
                if(count($existsAdd2000Point) == 0){
                    $this->createQuestForGame(6 ,$date_number);
                }
            }

            if($points >= 6000){
                $existsAdd6000Point = $this->checkQuestIsDoneForGame(7 ,$date_number);
                if(count($existsAdd6000Point) == 0){
                    $this->createQuestForGame(7 ,$date_number);
                }
            }

            $countQuestFinish = $this->countQuestIsFinishAll($date_number);

            if(count($countQuestFinish) == 9){
                $this->createQuestForGame(10 ,$date_number);
            }
        }
    }

    private function checkQuestIsDoneForGame(int $questId, int $date_number, int $isDone = 1){
        $exists = $this->modelQuestLog->where([
            ['quest_id', '=', $questId],
            ['date_number', '=', $date_number],
            ['user_id', '=', auth()->user()->id],
            ['is_done', '=', $isDone],
        ])->get();
        return $exists;
    }


    private function createQuestForGame(int $questId, int $date_number, int $isDone = 1){
        $data = array(
            'quest_id' => $questId,
            'date_number' => $date_number,
            'user_id' => auth()->user()->id,
            'is_done' => $isDone,
        );
        $result = $this->modelQuestLog->create($data);
        return $result;
    }

    public function countQuestIsFinishAll(int $date_number){
        $result = $this->modelQuestLog->where([
            ['date_number', '=', $date_number],
            ['user_id', '=', auth()->user()->id],
            ['is_done', '=', 1],
        ])->get();
        return $result;
    }
}