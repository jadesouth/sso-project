<?php
namespace sso\server;

/**
 * SSO服务器端
 */
class SSOServer
{
    /**
     * login 用户登录，验证用户登录信息,并进行登录
     *
     * @param string $username 用户登录名
     * @param string $password 用户原始密码
     *
	 * @return int 登录成功返回0,其余失败
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

        // 登录成功，生成token
		$timestamp = time();
		$salt = rand(10000, 99999);
		$token = Token::generateToken($username, $timestamp, $salt);
        // 写入全局Session
		session_id($token);
		session_name('SSOTOKEN');
        session_start();
		// Token信息
        $_SESSION['token']['token']     = $token;
        $_SESSION['token']['timestamp'] = $timestamp;
        $_SESSION['token']['salt']      = $salt;
		// 用户信息
        $_SESSION['user'] = $user;
		session_write_close();

		return 0;
    }

    /**
     * checkLogin 检测登录信息
     *
     * @param string $username 用户登录名
     * @param string $password  用户原始密码
     *
     * @return int 登录验证状态[0: OK, 1: user dose not exist, 2: password error]
     */
    private static function checkLogin(string $username, $password): int
    {
        // 获取已有用户信息
        $all_user_info = json_decode(file_get_contents('./user_info.json'));
        // 整理用户登录信息
        $user_names = [];
        foreach ($all_user_info as $key => $user_info) {
            $user_names[$user_info['username']] = $key;
        }
        // 验证用户登录信息
        if (! array_key_exists($username, $user_names)) {
            // 用户不存在
            return 1;
        }
        if ($password != $all_user_info[$user_names[$username]]['password']) {
            // 密码错误
            return 2;
        }

        return 0;
    }

    /**
     * getToken 根据用户名和密码生成 token
     *
     * @param string $username 用户名
     * @param string $password  用户原始密码
     *
     * @return string token
     */
    private static function getToken(string $username, string $password): string
    {
        return md5(md5(md5($username) . $password) . time());
    }
}
