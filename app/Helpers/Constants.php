<?php

namespace App\Helpers;
$questTmp = [
    [
        'id' => 1,
        'mochi' => 5,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 1
        ],
        'desc' => 'Đăng ký đi chơi công viên'
    ],
    [
        'id' => 2,
        'mochi' => 10,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 10
        ],
        'desc' => 'Rủ 10 thỏ ngọc khác cùng đi chơi',
        'code' => ''
    ],
    [
        'id' => 3,
        'mochi' => 10,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 10
        ],
        'desc' => 'Được 10 thỏ ngọc khác rủ đi chơi'
    ],
    [
        'id' => 4,
        'mochi' => 20,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 5
        ],
        'desc' => 'Tham gia trò chơi <b style="color: #317489;">Vòng Xoay Mặt Trời</b> 5 lần/ngày'
    ],
    [
        'id' => 5,
        'mochi' => 5,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 1
        ],
        'desc' => 'Lần đầu nhận được <b style="color: #317489;">Kim Tơ</b> trong ngày'
    ],
    [
        'id' => 6,
        'mochi' => 15,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 15
        ],
        'desc' => 'Thu thập được 15 <b style="color: #317489;">Kim Tơ</b>/ngày'
    ],
    [
        'id' => 7,
        'mochi' => 15,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 50
        ],
        'desc' => 'Thu thập được 50 <b style="color: #317489;">Kim Tơ</b>/ngày'
    ],
    [
        'id' => 8,
        'mochi' => 10,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 1
        ],
        'desc' => 'Ghi được 1500 điểm trong một lượt chơi tại <b style="color: #317489;">Vòng Xoay Mặt Trời</b>'
    ],
    [
        'id' => 9,
        'mochi' => 5,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 1
        ],
        'desc' => 'Ghé thăm <b style="color: #317489;">Thố Động</b> mỗi ngày'
    ],
    [
        'id' => 10,
        'mochi' => 15,
        'is_done' => 0,
        'is_received' => 0,
        'progress' => [
            'current' => 0,
            'max' => 1
        ],
        'desc' => 'Hoàn thành các nhiệm vụ trên mỗi ngày'
    ],
];
// event birthday 12
$eventBirthDay12 = [
    'mochi' => 2, // mỗi lượt chơi vòng xoay mặt trời tốn 2 mochi
    'time' => 5, // thời gian mỗi lượt chơi
    'point_lucky' => 6500, // điểm để đạt cột mốc may măn silk
    'type' => [
        'mochi' => 'mochi',
        'silk' => 'silk',
    ],
    'action' => [
        'plus' => 'plus',
        'minus' => 'minus',
    ],
    'secretKey' => 'jqRIMbaBP+XoHUem/M0Y8dIZ2DHuh7DJ'
];

define('EVENT_BIRTHDAY12', $eventBirthDay12);
define('QUEST_TMP', $questTmp);