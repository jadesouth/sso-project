<?php
namespace sso\client;

use sso\lib\CURL;

/**
 * SSOClient SSO客户端类
 */
class SSOClient
{
    /**
     * @var array 配置需要SSO登录的其他域名
     */
    private static $otherDomain = [
        'http://www.s2.com',
//        'http://www.s3.com',
    ];


    /**
     * login 向SSO服务端登录，成功登录后写入本地SESSION
     *
     * @param string $username 登录用户名
     * @param string $password 登录密码
     *
     * @return string 登录结果信息
     */
    public static function login(string $username, string $password): string
    {
        $curl = new CURL('http://www.sso.com/login.php');
        $post_data = [
            'username' => $username,
            'password' => $password,
        ];
        $res = $curl->post($post_data);
        $res = json_decode($res, true);
        if ($res['is_login']) {
            session_save_path('/tmp/sess/s1/');
            session_start();
            $_SESSION['token']    = $res['token'];
            $_SESSION['user']     = $res['user'];
            $_SESSION['is_login'] = true;
            return 'SUCCESS';
        } else {
            return $res['msg'];
        }
    }

    /**
     * otherDomainLogin 输出SSO登录其他域名的iframe
     *
     * @param string token SSO登录成功的Token
     *
     * @return string 登录其他域名的iframe
     */
    public static function otherDomainLogin(string $token): string
    {
        $iframe = '';
        foreach (self::$otherDomain as $domain) {
            $iframe .= '<iframe src="' . $domain . '/sso_login.php?token=' . $token . '" width="0" height="0" border="0" frameborder="0" style="display:none;"></iframe>';
        }

        return $iframe;
    }

    /**
     * ssoLogin 提供SSO被动登录功能
     *
     * @param string $token 被动登录的Token
     *
     * @return string 登录结果信息
     */
    public static function ssoLogin(string $token): string
    {
        // 检验Token合法性
        $curl = new CURL('http://www.sso.com/sso_login.php?token=' . $token);
        $curl->setCookies(['SSOTOKEN'=>$token]);
        $res = $curl->get();
        $res = json_decode($res, true);
        if ($res['is_login']) {
            session_start();
            $_SESSION['token']    = $token;
            $_SESSION['user']     = $res['user'];
            $_SESSION['is_login'] = true;
            return 'SUCCESS';
        } else {
            return $res['msg'];
        }
    }
}
