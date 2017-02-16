<?php
namespace sso\server;

/**
 * SSO服务器端
 */
class SSOServer
{
    /**
     * login 用户登录，验证用户登录信息
     *
     * @param string $username 用户登录名
     * @param string $password 用户原始密码
     *
     * @return int 校验成功返回0,其余失败
     */
    public static function login(string $username, string $password): int
    {
        // 获取登录用户信息
        $user = User::getUserByName($username);
        if (empty($user)) { // 用户不存在
            return -1;
        }
        if ($user['password'] != $password) { // 密码错误
            return -2;
        }

        return 0;
    }

    /**
     * logout SSO登出操作
     *
     * @return bool
     */
    public static function logout(): bool
    {
        // 销毁服务端SESSION
        session_unset();
        session_regenerate_id(true);
        $session_cookie_params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600,
            $session_cookie_params['path'], $session_cookie_params['domain'],
            $session_cookie_params['secure'], $session_cookie_params['httponly']
        );
        session_destroy();

        return true;
    }
}
