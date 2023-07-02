<?php
loadLayout('no_header');
if (isPost()) {
    $body = getBody();
    $errors = [];

    // validate
    validateEmail($body['email'], $errors);
    validateUsername($body['username'], $errors);
    validatePassword($body['password'], $errors);
    validateRetypePassword($body['password'], trim($body['retype_password']), $errors);

    if (empty($errors)) {
        $passwordHash = password_hash($body['password'], PASSWORD_DEFAULT);
        $dataInsert = [
            'username' => $body['username'],
            'email' => $body['email'],
            'password' => $passwordHash,
            'create_at' => date('Y-m-d H:i:s')
        ];
        $result = insertData('users', $dataInsert);
        if ($result) {
            showMessage('Register successfully', 'success');
            navigate('?module=auth&action=login', 1500);
        } else {
            showMessage('System is error, try again after', 'error');
        }
    } else {
        setFlashData('errors', $errors);
        setFlashData('pre_data', $body);
        navigate('?module=auth&action=register');
    }
}
$errors = getFlashData('errors');
$preData = getFlashData('pre_data');

?>
<section>

    <h2 class="text-center mt-5 mb-4 text-primary text-uppercase">Register
        <i class="fa-regular fa-registered"></i>
    </h2>
    <div class="w-100 d-flex justify-content-center">
        <form style="width: 500px;" class="p-4 bg-light border rounded" method="POST" action="">
            <div class="mb-3">
                <label class="fw-bold mb-1" for="email">Email</label>
                <input value="<?= $preData['email'] ?? '' ?>" name="email" class="form-control" type="text" id="email" placeholder="Enter your email...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['email'] ?? '' ?></p>
            </div>
            <div class="mb-3">
                <label class="fw-bold mb-1" for="username">Username</label>
                <input value="<?= $preData['username'] ?? '' ?>" name="username" class="form-control" type="text" id="username" placeholder="Enter your username...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['username'] ?? '' ?></p>

            </div>
            <div class="mb-3">
                <label class="fw-bold mb-1" for="password">Password</label>
                <input value="<?= $preData['password'] ?? '' ?>" name="password" class="form-control" type="password" id="password" placeholder="Enter your password...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['password'] ?? '' ?></p>
            </div>
            <div class="mb-3">
                <label class="fw-bold mb-1" for="retype_password">Retype Password</label>
                <input name="retype_password" class="form-control" type="password" id="retype_password" placeholder="Enter your retype password...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['retype_password'] ?? '' ?></p>

            </div>
            <button class="btn btn-primary px-5 mt-2" type="submit">Register</button>
            <p class="text-center mt-4">
                Do you already have an account?
                <a href="?module=auth&action=login" class="text-decoration-none">Login now</a>
            </p>
        </form>
    </div>
</section>

<?php loadLayout('no_footer') ?>