<?php
/**
 * 系统登出相关逻辑脚本
 */

// 引入相关文件
include __DIR__ . '/config.inc.php';
include __DIR__ . '/sso/SSOClient.class.php';
include __DIR__ . '/sso/lib/CURL.class.php';

session_start();
// 通知SSO退出登录
if (! empty($_SESSION['token'])) {
    $res = \sso\client\SSOClient::ssoLogout($_SESSION['token']);
    var_dump($res);
}
// 退出本地
if (! empty($_SESSION['is_login']) && true === $_SESSION['is_login']) {
    // 销毁本地SESSION
    session_unset();
    session_regenerate_id(true);
    $session_cookie_params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $session_cookie_params['path'], $session_cookie_params['domain'],
        $session_cookie_params['secure'], $session_cookie_params['httponly']
    );
    session_destroy();
}

header('Location: ' . LOCAL_URL);