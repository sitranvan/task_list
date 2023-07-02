<?php
session_start();
require_once 'config.php';
require_once 'public/phpmailer/Exception.php';
require_once 'public/phpmailer/PHPMailer.php';
require_once 'public/phpmailer/SMTP.php';
require_once 'includes/session.php';
require_once 'includes/connect.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/validate.php';

$module = isset($_GET['module']) && is_string($_GET['module']) ? trim($_GET['module']) : _MODULE_DEFAULT;
$action = isset($_GET['action']) && is_string($_GET['action']) ? trim($_GET['action']) : _ACTION_DEFAULT;

$path = _WEB_PATH_ROOT . "/modules/$module/$action.php";
if (file_exists($path)) {
    require_once $path;
} else {
    require_once  _WEB_PATH_ROOT . '/modules/errors/404.php';
}
