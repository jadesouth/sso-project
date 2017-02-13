<?php
    session_start();
    $is_login = empty($_SESSION['is_login']) ? false : true;
?>
<html>
    <head>
        <title>系统1</title>
    </head>
    <body style="margin:60px auto;text-align:center;">
        <h2>我是系统1，域名：www.s1.com</h2>
        <br/>
        <?php if (!$is_login):?>
        <h3>欢迎您，<?=$_SESSION['username']?></h3>
        <a href="./logout.php">退出系统1</a>
        <?php else:?>
        <h3>您还未登录,请先<a href="./login.php">登录系统1</a></h3>
        <?php endif;?>
    </body>
</html>
