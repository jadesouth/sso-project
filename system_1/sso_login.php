<?php
$token = (string)$_GET['token'];

include __DIR__ . '/sso/client/SSOClient.class.php';

$res = sso\client\SSOClient::ssoLogin($token);
