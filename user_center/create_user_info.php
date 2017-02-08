<?php

/**
 * 创建模拟用户
 */
$user_info[] = [
    'id'       => 1,
    'username' => 'foo',
    'password' => 'bar',
];
$user_info[] = [
    'id'       => 2,
    'username' => 'zhangsan',
    'password' => '111111',
];
$user_info[] = [
    'id'       => 2,
    'username' => 'lisi',
    'password' => '111111',
];
$user_info[] = [
    'id'       => 2,
    'username' => 'wangwu',
    'password' => '111111',
];
$user_info[] = [
    'id'       => 2,
    'username' => 'zhaoliu',
    'password' => '111111',
];

file_put_contents('./user_info.json', json_encode($user_info));
