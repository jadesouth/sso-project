<?php
/**
 * 服务端用户登录逻辑处理脚本
 */

use sso\server\SSOServer;
use sso\server\Token;
use sso\server\User;

// 引入需要的文件
include __DIR__ . '/lib/SSOServer.class.php';
include __DIR__ . '/lib/User.class.php';
include __DIR__ . '/lib/Token.class.php';

// 检验登录
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    // 用户名密码校验
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $result = SSOServer::login($username, $password);

    if (0 === $result) { // 校验OK
        // 获取登录用户信息
        $user = User::getUserByName($username);
        save_sso_session($user);

        // 返回客户端登录成功信息
        $return = [
            'is_login' => true,
            'msg'      => 'SUCCESS',
            'token'    => $_SESSION['token']['token'],
            'user'     => [
                'id'       => $user['id'],
                'username' => $user['username']
            ],
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

/**
 * save_sso_session SESSION记录登录用户信息
 *
 * @param array $user 用户信息
 */
function save_sso_session(array $user)
{
    // 生成Token相关信息
    $timestamp = time();
    $salt      = rand(10000, 99999);
    $token     = Token::generateToken($user['username'], $timestamp, $salt);
    /* 记录SSO服务端登录全局SESSION */
    session_name('SSOTOKEN');
    session_id($token);
    session_start();
    $_SESSION['token']['timestamp'] = $timestamp;
    $_SESSION['token']['salt']      = $salt;
    $_SESSION['token']['token']     = $token;
    // 用户信息
    $_SESSION['user'] = $user;
    session_write_close();
}