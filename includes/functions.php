
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Tải layout
function loadLayout($layoutName = '', $data = [])
{
    if (file_exists(_WEB_PATH_ROOT . '/layouts/' . $layoutName . '.php')) {
        require_once _WEB_PATH_ROOT . '/layouts/' . $layoutName . '.php';
    }
}

// Điều hướng
function navigate($url = '', $delay = 0)
{
    if (!empty($url)) {
        if ($delay) {
            echo '<script>setTimeout(function() { window.location.href = "' . $url . '"; }, ' . $delay . ');</script>';
        } else {
            header('Location: ' . $url);
        }
        exit();
    }
}



// hiển thị thông báo dùng thư viện sweetalert
function showMessage($msg, $type)
{
    echo "<script>";
    echo 'swal("' . $msg . '","", "' . $type . '");';
    echo "</script>";
}

// Kiểm tra xem có $_GET không
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

// lấy dữ liệu từ url đã được chuẩn hóa
function getBody()
{
    $bodyArr = [];

    if (isGet() && !empty($_GET)) {
        foreach ($_GET as $key => $value) {
            $key = strip_tags($key);
            $bodyArr[$key] = is_array($value) ? filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) : filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }

    if (isPost() && !empty($_POST)) {
        foreach ($_POST as $key => $value) {
            $key = strip_tags($key);
            $bodyArr[$key] = is_array($value) ? filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY) : filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }

    return $bodyArr;
}

// kiểm tra xem đã đăng nhập chưa
function isLogin()
{
    $loginToken = getCookie('login');

    if (!empty($loginToken) && isset($loginToken)) {

        $result = getExists("SELECT user_id FROM login WHERE token='$loginToken'");
        if ($result) {
            return true;
        } else {
            setcookie('login', '', time() - 36000);
            return false;
        }
    } else {
        return false;
    }
}

function getUserLogin()
{
    $token = getCookie('login');
    if (!empty($token)) {
        $loginToken = getData('login', 'user_id', "token='$token'");
        $userId = $loginToken['user_id'];
        return  getData('users', '*', "user_id='$userId'");
    }
}

function sendMail($to, $subject, $content)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sitran.dev@gmail.com';
        $mail->Password   = 'uwbmopdmozkwtdqg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('sitran.dev@gmail.com', 'Trần Sĩ');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $content;

        return $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
