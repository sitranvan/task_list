<?php
loadLayout('no_header');

$forgotToken = getBody()['token'] ?? '';
if (!empty($forgotToken)) {
    $userToken = getData('users', 'user_id', "forgot_token='$forgotToken'");
    if (!empty($userToken)) {
        $userId = $userToken['user_id'];
        if (isPost()) {
            $body = getBody();
            $errors = [];
            validatePassword($body['password'], $errors);
            validateRetypePassword($body['password'], $body['retype_password'], $errors);
            if (empty($errors)) {
                $passwordHash =  password_hash($body['password'], PASSWORD_DEFAULT);
                $dataUpdate = [
                    'password' => $passwordHash,
                    'forgot_token' => null,
                    'update_at' => date('Y-m-d H:i:s')
                ];
                $resultUpdate = updateData('users', $dataUpdate, "user_id='$userId'");
                if ($resultUpdate) {
                    showMessage('Update password successfully', 'success');
                    navigate('?module=auth&action=login', 1500);
                } else {
                    showMessage('System is error, please try again later', 'error');
                }
            } else {
                setFlashData('errors', $errors);
                navigate('?module=auth&action=reset&token=' . $forgotToken);
            }
        }
?>
        <section>
            <h2 class="text-center mt-5 mb-4 text-primary text-uppercase">
                Change password
                <i class="fa-solid fa-unlock"></i>
            </h2>
            <div class="w-100 d-flex justify-content-center">
                <form style="width: 500px;" class="p-4 bg-light border rounded" method="POST" action="">

                    <div class="mb-3">
                        <label class="fw-bold mb-1" for="password">Password</label>
                        <input value="<?= $preData['password'] ?? '' ?>" name="password" class="form-control" type="password" id="password" placeholder="Enter your password...">
                        <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['password'] ?? '' ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold mb-1" for="retype_password">Retype Password</label>
                        <input name="retype_password" class="form-control" type="password" id="retype_password" placeholder="Enter your retype password...">
                        <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['retype_password'] ?? '' ?></p>
                        <input type="hidden" value="<?= $forgotToken ?>" name="token">
                    </div>
                    <button class="btn btn-primary px-5 mt-2" type="submit">Submit</button>
                </form>
            </div>
        </section>
<?php
    } else {
        echo '<div class="alert alert-danger" role="alert">
        The link does not exist or is out of date
        </div>';
    }
    $errors = getFlashData('errors');
} else {
    echo '<div class="alert alert-danger" role="alert">
    The link does not exist or is out of date
    </div>';
}

loadLayout('no_footer');
?>