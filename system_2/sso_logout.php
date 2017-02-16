<?php
/**
 * SSO登出相关逻辑脚本
 */

// 引入相关文件
include __DIR__ . '/config.inc.php';

session_start();
// 检测是否已经登录
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

echo 'SUCCESS';