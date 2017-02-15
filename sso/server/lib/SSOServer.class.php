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
}
