<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Http\Response;
use App\Helpers\Message;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Helpers
{
    protected $msg;
    protected $modelUser;
    protected $ldapHost;

    public function __construct(
        Message $message,
        User    $modelUser
    )
    {
        $this->msg = $message;
        $this->ldapHost = env("LDAP_HOST", "222.255.168.250");
        $this->modelUser = $modelUser;
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
                $results['content'] = sprintf('Bạn đã nhận được %d Kim Tơ ở Vòng Xoay Mặt Trời', $arr['points']);
                $results['points'] = $arr['points'];
                $results['points'] = $arr['points'];
            }
            if ($arr['type'] == EVENT_BIRTHDAY12['type']['mochi']) {
                $results['action'] = EVENT_BIRTHDAY12['action']['plus'];
                $results['content'] = sprintf('Bạn đã nhận được %d mochi trong nhiệm vụ %d', $arr['point'], $arr['name_quest']);
                $results['points'] = $arr['points'];
            }
        }
        $results['user_id'] = auth()->user()->id;
        return $results;
    }

}