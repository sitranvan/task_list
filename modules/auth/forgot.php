<?php loadLayout('no_header');
if (isLogin()) {
    navigate('?module=task&action=list');
}
if (isPost()) {
    $email = getBody()['email'];
    $errors = [];
    validateEmail($email, $errors, isExists: false);
    if (empty($errors)) {
        $userForgot = getData('users', '*', "email='$email'");
        if (!empty($userForgot)) {
            $userId = $userForgot['user_id'];
            $forgotToken = sha1(uniqid() . time());
            $dataUpdate = [
                'forgot_token' => $forgotToken,
                'update_at' => date('Y-m-d H:i:s')
            ];
            $result = updateData('users', $dataUpdate, "user_id='$userId'");
            if ($result) {
                $linkReset = _WEB_HOST_ROOT . '?module=auth&action=reset&token=' . $forgotToken;
                $subject = 'Request password recovery';
                $content = 'We received a request to recover your password, please click on the following link to recover <br>';
                $content .= $linkReset . '<br>';
                $sendResult = sendMail($email, $subject, $content);
                if ($sendResult) {
                    showMessage('Please check your email', 'success');
                } else {
                    showMessage('System is error, please try again after', 'error');
                }
            } else {
                showMessage('System is error, please try again after', 'error');
            }
        }
    } else {
        setFlashData('errors', $errors);
        navigate('?module=auth&action=forgot');
    }
}
$errors = getFlashData('errors');
?>
<section>
    <h2 class="text-center mt-5 mb-4 text-primary text-uppercase">Forgot Password
        <i class="fa-solid fa-key "></i>
    </h2>
    <div class="w-100 d-flex justify-content-center flex-column align-items-center">
        <form style="width: 500px;" class="p-4 bg-light border rounded" method="POST" action="">
            <div class="mb-3">
                <label class="fw-bold mb-1" for="email">Email</label>
                <input value="<?= $preData['email'] ?? '' ?>" name="email" class="form-control" type="text" id="email" placeholder="Enter your email...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['email'] ?? '' ?></p>
            </div>
            <button class="btn btn-primary px-5 mt-2" type="submit">Submit Email</button>
            <p class="text-center mt-4">
                Login with password?
                <a href="?module=auth&action=login" class="text-decoration-none">Login now</a>
            </p>
        </form>
    </div>
</section>
<?php loadLayout('no_footer');  ?>