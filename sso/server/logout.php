<?php
/**
 * SSO 服务端登出脚本
 */

use sso\server\SSOServer;
use sso\server\Token;

// 引入需要的文件
include __DIR__ . '/lib/SSOServer.class.php';
include __DIR__ . '/lib/Token.class.php';
include dirname(__DIR__) . '/lib/CURL.class.php';

$token = (string)$_GET['token'];
session_name('SSOTOKEN');
session_save_path('/tmp/sess/sso/');
session_start();
if (Token::checkToken($token)) {
    if (SSOServer::logout($token)) {
        die(json_encode(['status' => true, 'msg' => 'SUCCESS']));
    } else {
        die(json_encode(['status' => false, 'msg' => 'LOGOUT FAILURE']));
    }
} else {
    die(json_encode(['status' => false, 'msg' => 'TOKEN INVALID']));
}
