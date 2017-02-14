<?php
/**
 * 服务端用户登录逻辑处理脚本
 */

use sso\server\SSOServer;

// 引入需要的文件
include(__DIR__ . DIRECTORY_SEPARATOR . 'server' . DIRECTORY_SEPARATOR . 'SSOServer.class.php');
include(__DIR__ . DIRECTORY_SEPARATOR . 'server' . DIRECTORY_SEPARATOR . 'User.class.php');
include(__DIR__ . DIRECTORY_SEPARATOR . 'server' . DIRECTORY_SEPARATOR . 'Token.class.php');

// 检验登录
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $result = SSOServer::login($username, $password);

    if (0 == $result) { // 登录成功
        session_start();
        $return = [
            'is_login' => true,
            'msg'      => 'SUCCESS',
            'token'    => $_SESSION['token']['token'],
            'user'     => ['id' => $_SESSION['user']['id'],'username' => $_SESSION['user']['username']],
        ];
        die(json_encode($return, true));
    } elseif (-1 == $result) {
        die(json_encode(['is_login' => false, 'msg' => 'USER NOT EXISTS.']));
    } elseif (-2 == $result) {
        die(json_encode(['is_login' => false, 'msg' => 'PASSWORD ERROR.']));
    } else {
        die(json_encode(['is_login' => false, 'msg' => 'UNKNOWN ERROR.']));
    }
} else {
    die(json_encode(['is_login' => false, 'msg' => 'OPERATION NOT ALLOWED.'], true));
}
