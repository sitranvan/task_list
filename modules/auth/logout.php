<?php
if (isLogin()) {
    $token = getCookie('login');
    deleteData('login', "token='$token'");
    navigate('?module=auth&action=login');
}
