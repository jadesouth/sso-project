<?php
use sso\client\SSOClient;

if ('POST' == $_SERVER['REQUEST_METHOD']):
    // 获取登录的用户名密码
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // SSO 路径
    define('SSO_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'sso' . DIRECTORY_SEPARATOR);
    // 引入必要文件
    include SSO_DIR . 'client' . DIRECTORY_SEPARATOR . 'SSOClient.class.php';
    include SSO_DIR . 'lib' . DIRECTORY_SEPARATOR . 'CURL.class.php';
    // 进行SSO登录
    $res = SSOClient::login($username, $password);
    if ('SUCCESS' == $res) {
        header('Location:./index.php');
    } else {
        echo "<div style=\"margin:30px auto;text-align:center;\">登录失败：<span style=\"color:red\">{$res}</span>";
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
        <form action="./login.php" method="post">
            <p>用户名：<input type="text" name="username" placeholder="请输入用户名"></p>
            <p>密　码：<input type="password" name="password" placeholder="请输入登录密码"></p>
            <p><input type="submit" name="submit" value="登录"></p>
        </form>
    </body>
</html>
<?php endif;?>
