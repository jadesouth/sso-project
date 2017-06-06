<?php

// 引入相关文件
include __DIR__ . '/config.inc.php';
session_start();
// 检测是否已经登录
if (! empty($_SESSION['is_login']) && true === $_SESSION['is_login']) {
    echo 'SUCCESS';
    return;
}

// 进行SSO登录
include __DIR__ . '/sso/SSOClient.class.php';
include __DIR__ . '/sso/lib/CURL.class.php';

$token = (string)$_GET['token'];
$res = \sso\client\SSOClient::ssoLogin($token);

$res = json_decode($res, true);
if ('SUCCESS' == $res['is_login']) {
    $_SESSION['token']    = $res['token'];
    $_SESSION['user']     = $res['user'];
    $_SESSION['is_login'] = true;
    echo 'SUCCESS';
} else {
    echo $res['msg'];
}