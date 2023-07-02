<?php

function setSession($key = '', $value = '')
{
    if (!empty(session_id())) {
        $_SESSION[$key] = $value;
    }
}

function getSession($key = '')
{
    if (isset($_SESSION[$key])) {
        return $_SESSION[$key];
    }
    return $_SESSION;
}

function removeSession($key = '')
{
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}

function setFlashData($key = '', $value = '')
{
    $key = 'flash_' . $key;
    return setSession($key, $value);
}

function getFlashData($key = '')
{
    $key = 'flash_' . $key;
    $data = getSession($key);
    removeSession($key);
    return $data;
}
function getCookie($name)
{
    if (isset($_COOKIE[$name])) {
        return $_COOKIE[$name];
    } else {
        return null;
    }
}
