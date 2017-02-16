<?php
    // 引入配置文件
    include __DIR__ . '/config.inc.php';
    session_save_path(SESSION_PATH);
    session_start();
    $is_login = empty($_SESSION['is_login']) ? false : true;
?>
<html>
    <head>
        <title>系统2</title>
    </head>
    <body style="margin:60px auto;text-align:center;">
        <h2>我是系统2，域名：www.s2.com</h2>
        <br/>
        <?php if ($is_login):?>
        <h3>欢迎您，<?=$_SESSION['user']['username']?></h3>
        <a href="./logout.php">退出系统2</a>
        <?php
            include dirname(__DIR__) . '/sso/client/SSOClient.class.php';
            $iFrame = sso\client\SSOClient::otherDomainLogin($_SESSION['token']);
            echo $iFrame;
        ?>
        <?php else:?>
        <h3>您还未登录,请先<a href="./login.php">登录系统2</a></h3>
        <?php
            include dirname(__DIR__) . '/sso/client/SSOClient.class.php';
            $iFrame = sso\client\SSOClient::otherDomainLogout();
            echo $iFrame;
        ?>
        <?php endif;?>
    </body>
</html>
