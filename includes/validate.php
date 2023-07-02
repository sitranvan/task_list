<?php
function validateEmail($email = '', &$errors = [], $isExists = true)
{
    if (empty(trim($email))) {
        $errors['email'] = 'Email required to enter';
    } else {
        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalid';
        } else {
            if ($isExists) {
                $email = trim($email);
                $sql = "SELECT user_id FROM users WHERE email='$email'";
                if (getExists($sql)) {
                    $errors['email'] = 'Email already exists in the system';
                }
            }
        }
    }
}

function validateUsername($username = '', &$errors = [], $login = false)
{
    if (empty(trim($username))) {
        $errors['username'] = 'Usrname required to enter';
    } else {
        if (strlen(trim($username)) <= 5) {
            $errors['username'] = 'Username more than 5 characters';
        } else {
            if (!$login) {
                $username = trim($username);
                $sql = "SELECT user_id FROM users WHERE username='$username'";
                if (getExists($sql)) {
                    $errors['username'] = 'Username already exists in the system';
                }
            }
        }
    }
}

function validatePassword($password = '', &$errors = [], $currentPassword = false)
{
    if (empty(trim($password))) {
        $errors['password'] = 'Password required to enter';
    } else {
        if (strlen(trim($password)) <= 5) {
            $errors['password'] = 'Password more than 5 characters';
        }
        if ($currentPassword) {
            $token = getCookie('login');

            $passwordHash = getUserLogin()['password'];
            if (!password_verify($password, $passwordHash)) {
                $errors['password'] = 'Current password is incorrect';
            }
        }
    }
}

function validateNewPassword($newPassword = '', &$errors = [])
{
    if (empty(trim($newPassword))) {
        $errors['new_password'] = 'Password required to enter';
    } else {
        if (strlen(trim($newPassword)) <= 5) {
            $errors['new_password'] = 'New password more than 5 characters';
        }
        $passwordHash = getUserLogin()['password'];
        if (password_verify($newPassword, $passwordHash)) {
            $errors['new_password'] = 'The new password is the same as the old password';
        }
    }
}


function validateRetypePassword($password, $retype_password, &$errors = [])
{
    if (empty(trim($retype_password))) {
        $errors['retype_password'] = 'Retype password required to enter';
    } else {
        if (trim($password) != trim($retype_password)) {
            $errors['retype_password'] = 'Password does not match';
        }
    }
}
