<?php
namespace sso\server;

/**
 * Class Token token相关操作类
 */
class Token
{
    /**
     * generateToken 生成Token
     *
     * @param string $username  用户名
     * @param int    $timestamp Token生成时间戳
     * @param string $salt      盐值
     *
     * @return string 生成的token
     */
    public static function generateToken(string $username, int $timestamp, string $salt): string
    {
        return md5(md5(md5($username) . $timestamp) . $salt);
    }

    /**
     * checkToken 检查Token是否正确
     *
     * @param string $token Token串
     * @return bool
     */
    public static function checkToken(string $token): bool
    {
        if ($token == $_SESSION['token']['token']) {
            return true;
        }

        return false;
    }
}
