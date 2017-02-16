<?php
/**
 * 服务端用户SSO登录逻辑处理脚本
 */

use sso\server\Token;

// 引入需要的文件
include __DIR__ . '/lib/SSOServer.class.php';
include __DIR__ . '/lib/Token.class.php';

$token = (string)$_GET['token'];
session_name('SSOTOKEN');
session_save_path('/tmp/sess/sso/');
session_start();
if (Token::checkToken($token)) {
    $user = [
        'id'       => $_SESSION['user']['id'],
        'username' => $_SESSION['user']['username']
    ];
    die(json_encode(['is_login' => true, 'msg' => 'SUCCESS', 'user' => $user]));
} else {
    die(json_encode(['is_login' => false, 'msg' => 'TOKEN ERROR']));
}
