<?php

/**
 * SSO服务器端
 */
class SSOService
{
	/**
	 * login 用户登录，验证用户登录信息
	 *
	 * @param string $username 用户登录名
	 * @param string $password  用户原始密码
	 *
	 */
    public static function login(string $username, string $password)
    {
		// 检测登录
		$res = self::checkLogin($username, $password);

		// 登录成功，获取token
		$token = self::getToken($username, $password);
		// 写入全局Session
		session_start();
		$_SESSION['token'] = $token;
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
