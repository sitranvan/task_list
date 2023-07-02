<?php
if (isLogin()) {
    navigate('?module=task&action=list');
}
loadLayout('no_header');
if (isPost()) {
    $body = getBody();
    $errors = [];
    validateUsername($body['username'], $errors, login: true);
    validatePassword($body['password'], $errors);
    if (empty($errors)) {
        $username = $body['username'];
        $password = $body['password'];
        $userQuery = getData('users', 'user_id,username,password', "username='$username'");
        if (!empty($userQuery)) {
            $userId = $userQuery['user_id'];
            $passwordHash = $userQuery['password'];
            if (password_verify($password, $passwordHash)) {
                $tokenLogin = sha1(uniqid() . time());
                $dataLogin = [
                    'user_id' => $userId,
                    'token' => $tokenLogin,
                    'create_at' => date('Y-m-d H:i:s'),
                ];
                $result = insertData('login', $dataLogin);
                if ($result) {
                    setcookie('login', $tokenLogin, time() + 36000);
                    showMessage('Login successfully', 'success');
                    navigate('?module=task&action=list', 1500);
                } else {
                    showMessage('The system failed, please try again later', 'error');
                }
            } else {
                setFlashData('msg', 'Password is incorrect');
            }
        } else {
            setFlashData('msg', 'Username is incorrect');
        }
    } else {
        setFlashData('errors', $errors);
        setFlashData('pre_data', $body);
        navigate('?module=auth&action=login');
    }
}
$msg = getFlashData('msg');
$errors = getFlashData('errors');
$preData = getFlashData('pre_data');

?>

<section>
    <h2 class="text-center mt-5 mb-4 text-primary text-uppercase">Login
        <i class="fa-solid fa-arrow-right-to-bracket"></i>
    </h2>
    <div class="w-100 d-flex justify-content-center flex-column align-items-center">
        <?php if (!empty($msg) && !is_array($msg)) echo '<div style="width: 500px;" class="alert-danger p-2 mb-4 text-center">' . $msg . '</div>' ?>
        <form style="width: 500px;" class="p-4 bg-light border rounded" method="POST" action="">
            <div class="mb-3">
                <label class="fw-bold mb-1" for="username">Username</label>
                <input value="<?= $preData['username'] ?? '' ?>" name="username" class="form-control" type="text" id="username" placeholder="Enter your username...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['username'] ?? '' ?></p>

            </div>
            <div class="mb-4">
                <label class="fw-bold mb-1" for="password">Password</label>
                <input value="<?= $preData['username'] ?? '' ?>" name="password" class="form-control" type="password" id="password" placeholder="Enter your password...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['password'] ?? '' ?></p>

            </div>
            <div class="mb-3 d-flex justify-content-end">
                <a class="text-decoration-none" href="?module=auth&action=forgot">
                    <i class="fa-solid fa-key "></i>
                    Forgot password
                </a>
            </div>
            <button class="btn btn-primary px-5 mt-2" type="submit">Login</button>
            <p class="text-center mt-4">
                Do not have an account?
                <a href="?module=auth&action=register" class="text-decoration-none">Register now</a>
            </p>
        </form>
    </div>
</section>

<?php loadLayout('no_footer') ?>