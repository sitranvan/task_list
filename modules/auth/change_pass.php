<?php
loadLayout('no_header');
if (!isLogin()) {
    navigate('?module=auth&action=login');
}
if (isPost()) {
    $body = getBody();
    $errors = [];
    validatePassword($body['password'], $errors, currentPassword: true);
    validateNewPassword($body['new_password'], $errors);
    validateRetypePassword($body['new_password'], $body['new_retype_password'], $errors);
    if (empty($errors)) {
        $token = getCookie('login');
        if (!empty($token)) {
            $userId = getUserLogin()['user_id'];
            $passwordHash = password_hash($body['new_password'], PASSWORD_DEFAULT);
            $dataUpdate = [
                'password' => $passwordHash,
                'update_at' => date('Y-m-d H:i:s')
            ];
            $resultUpdate = updateData('users', $dataUpdate, "user_id='$userId'");
            if ($resultUpdate) {
                showMessage('Password successfully changed', 'success');
                navigate('?module=task&action=list', 1500);
            } else {
                showMessage('System is error, try again after', 'error');
            }
        }
    } else {
        setFlashData('errors', $errors);
        setFlashData('pre_data', $body);
        navigate('?module=auth&action=change_pass');
    }
}

$errors = getFlashData('errors');
$preData = getFlashData('pre_data');

?>
<section>

    <h2 class="text-center mt-5 mb-4 text-primary text-uppercase">
        Change password
        <i class="fa-solid fa-unlock"></i>
    </h2>
    <div class="w-100 d-flex justify-content-center">
        <form style="width: 500px;" class="p-4 bg-light border rounded" method="POST" action="">

            <div class="mb-3">
                <label class="fw-bold mb-1" for="password">Current password</label>
                <input value="<?= $preData['password'] ?? '' ?>" name="password" class="form-control" type="password" id="password" placeholder="Enter your current password...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['password'] ?? '' ?></p>
            </div>
            <div class="mb-3">
                <label class="fw-bold mb-1" for="retype_password">New Password</label>
                <input name="new_password" class="form-control" type="password" id="retype_password" placeholder="Enter your new password...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['new_password'] ?? '' ?></p>
                <input type="hidden" value="<?= $forgotToken ?>" name="token">
            </div>
            <div class="mb-3">
                <label class="fw-bold mb-1" for="retype_password">New Retype Password</label>
                <input name="new_retype_password" class="form-control" type="password" id="new_retype_password" placeholder="Enter your new retype password...">
                <p style="font-style: italic; font-size:14px;" class="text-danger ms-1"><?= $errors['retype_password'] ?? '' ?></p>
                <input type="hidden" value="<?= $forgotToken ?>" name="token">
            </div>
            <button class="btn btn-primary px-5 mt-2" type="submit">Submit</button>
        </form>
    </div>
</section>

<?php loadLayout('no_footer') ?>