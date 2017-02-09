<?php
/**
 * 服务端用户登录逻辑处理脚本
 */

// 引入需要的文件
include(__DIR__ . DIRECTORY_SEPARATOR . 'sso' . DIRECTORY_SEPARATOR . 'SSOService.class.php');
include(__DIR__ . DIRECTORY_SEPARATOR . 'sso' . DIRECTORY_SEPARATOR . 'User.class.php');
include(__DIR__ . DIRECTORY_SEPARATOR . 'sso' . DIRECTORY_SEPARATOR . 'Token.class.php');

// 检验登录
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $user_name = $_POST['user_name'];
    $password  = $_POST['password'];
    $result = SSOService::login($user_name, $password);

    if (0 == $result) {
        die('SUCCESS');
    } elseif (-1 == $result) {
        die('USER NOT EXISTS.');
    } elseif (-2 == $result) {
        die('PASSWORD ERROR.');
    } else {
        die('UNKNOWN ERROR.');
    }
} else {
    die('OPERATION NOT ALLOWED.');
}
