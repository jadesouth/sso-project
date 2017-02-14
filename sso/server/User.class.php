<?php
namespace sso\server;

/**
 * Class User 用户类
 *     模拟获取一些用户数据,可以根据自己实际情况获取用户数据,比如从MySQL获取
 */
class User
{
    /**
     * getUser 根据用户ID获取用户信息数据
     *
     * @param int $user_id 用户ID
     *
     * @return array 用户信息,用户不存在返回空数组
     */
    public static function getUser(int $user_id): array
    {
        if (0 >= $user_id) {
            return [];
        }

        // 获取所有用户信息
        $all_user_info = self::getAllUser();

        return empty($all_user_info[$user_id]) ? [] : $all_user_info[$user_id];

    }

    /**
     * getUserByName 根据用户登录名获取用户信息
     *
     * @param string $name 用户名
     *
     * @return array 用户信息,用户不存在返回空数组
     */
    public static function getUserByName(string $name): array
    {
        if (empty($name)) {
            return [];
        }

        // 获取所有用户信息
        $all_user_info = self::getAllUser();

        // 返回用户信息
        foreach ($all_user_info as $user_info) {
            if ($name == $user_info['username']) {
                return $user_info;
            }
        }

        return [];
    }

    /**
     * getAllUser 获取所有的用户
     *
     * @return array 下标为用户ID的用户数组信息,无用户返回空数组
     */
    private static function getAllUser(): array
    {
        $all_user_info = [];
        // 获取所有用户信息
        $raw_user_info = json_decode(file_get_contents('./user_info.json'), true);
        if(! empty($raw_user_info)) {
            foreach($raw_user_info as $user) {
                $all_user_info[$user['id']] = $user;
            }
        }

        return $all_user_info;
    }
}
