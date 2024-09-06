<?php
namespace App\Helpers;
// event birthday 12
$eventBirthDay12 = [
    'mochi' => 2, // mỗi lượt chơi vòng xoay mặt trời tốn 2 mochi
    'time'  => 0.5, // thời gian mỗi lượt chơi
    'point_lucky' => 6000, // điểm để đạt cột mốc may măn silk
    'type' => [
        'mochi' => 'mochi',
        'silk' => 'silk',
    ],
    'action' => [
        'plus' => 'plus',
        'minus' => 'minus',
    ]
];

define('EVENT_BIRTHDAY12', $eventBirthDay12);