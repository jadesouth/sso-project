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
    private static $otherDomain = SSO_OTHER_DOMAIN;


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
        $curl = new CURL(SSO_ACTIVE_SERVER);
        $post_data = [
            'username' => $username,
            'password' => $password,
        ];
        $res = $curl->post($post_data);
        $res = json_decode($res, true);
        if ($res['is_login']) {
            $return = [
                'is_login' => true,
                'token'    => $res['token'],
                'msg'      => 'SUCCESS',
                'user'     => $res['user'],
            ];
            return json_encode($return, true);
        } else {
            return json_encode(['is_login' => false, 'msg' => $res['msg']]);
        }
    }

    /**
     * otherDomainLogin 输出SSO登录其他域名的iFrame
     *
     * @param string $token SSO登录成功的Token
     *
     * @return string 登录其他域名的iFrame
     */
    public static function otherDomainLogin(string $token): string
    {
        $iFrame = '';
        foreach (self::$otherDomain as $domain) {
            $iFrame .= '<iframe src="' . $domain . '/sso_login.php?token=' . $token . '" width="0" height="0" border="0" frameborder="0" style="display:none;"></iframe>';
        }

        return $iFrame;
    }

    /**
     * ssoLogin 提供SSO被动登录功能
     *
     * @param string $token 被动登录的Token
     *
     * @return string 登录结果JSON信息
     */
    public static function ssoLogin(string $token): string
    {
        // 检验Token合法性
        $curl = new CURL(SSO_PASSIVE_SERVER . '?token=' . $token);
        $curl->setCookies(['SSOTOKEN'=>$token]);
        $res = $curl->get();
        $res = json_decode($res, true);
        if ($res['is_login']) {
            $return = [
                'is_login' => true,
                'token'    => $token,
                'msg'      => 'SUCCESS',
                'user'     => $res['user'],
            ];
            return json_encode($return, true);
        } else {
            return json_encode(['is_login' => false, 'msg' => $res['msg']]);
        }
    }
}