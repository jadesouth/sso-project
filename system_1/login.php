<?php
// 引入配置文件
include __DIR__ . '/config.inc.php';

use sso\client\SSOClient;

if ('POST' == $_SERVER['REQUEST_METHOD']):
    // 引入必要文件
    include __DIR__ . '/sso/SSOClient.class.php';
    include __DIR__ . '/sso/lib/CURL.class.php';
    // 获取登录的用户名密码
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    // 进行SSO登录
    session_start();
    $res = SSOClient::login($username, $password);
    $res = json_decode($res, true);
    if ('SUCCESS' == $res['is_login']) {
        $_SESSION['token']    = $res['token'];
        $_SESSION['user']     = $res['user'];
        $_SESSION['is_login'] = true;
        header('Location: ' . LOCAL_URL);
    } else {
        echo "<div style=\"margin:30px auto;text-align:center;\">登录失败：<span style=\"color:red\">{$res['msg']}</span>";
    }
else:
?>
<html>
    <head>
        <title>登录系统1</title>
    </head>
    <body style="margin:60px auto;text-align:center;">
        <h2>我是系统1，域名：www.s1.com</h2>
        <br/>
        <h3>登录表单</h3>
        <form action="http://www.s1.com/login.php" method="post">
            <p>用户名：<input type="text" name="username" placeholder="请输入用户名"></p>
            <p>密　码：<input type="password" name="password" placeholder="请输入登录密码"></p>
            <p><input type="submit" name="submit" value="登录"></p>
        </form>
    </body>
</html>
<?php endif;?>
