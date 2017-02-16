<?php
    // 引入配置文件
    include __DIR__ . '/config.inc.php';
    session_save_path(SESSION_PATH);
    session_start();
    var_dump($_COOKIE, session_name(), session_id(), $_SESSION);
    $is_login = empty($_SESSION['is_login']) ? false : true;
?>
<html>
    <head>
        <title>系统1</title>
    </head>
    <body style="margin:60px auto;text-align:center;">
        <h2>我是系统1，域名：www.s1.com</h2>
        <br/>
        <?php if ($is_login):?>
        <h3>欢迎您，<?=$_SESSION['user']['username']?></h3>
        <a href="./logout.php">退出系统1</a>
        <?php
            include dirname(__DIR__) . '/sso/client/SSOClient.class.php';
            $iFrame = sso\client\SSOClient::otherDomainLogin($_SESSION['token']);
            echo $iFrame;
        ?>
        <?php else:?>
        <h3>您还未登录,请先<a href="./login.php">登录系统1</a></h3>
        <?php endif;?>
    </body>
</html>
