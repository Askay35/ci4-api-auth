<?php

namespace App\Controllers;

use App\Libraries\ApiResponseTrait;
use App\Models\UserModel;

class Auth extends BaseController
{
    use ApiResponseTrait;


    public function register()
    {
        $register_data = request()->getPost();

        if (!$this->validateData($register_data, 'register')) {
            return $this->respondErrors($this->validator->getErrors());
        }
        helper('email');
        $db = \Config\Database::connect();
        $code = random_int(100000, 999999);
        if (sendVerificationCode($register_data['email'], $code)) {
            $user_model = new UserModel;
            $register_data['password'] = password_hash($register_data['password'], PASSWORD_BCRYPT);
            $user_model->save($register_data);

            $db->table('email_verifications')->insert(['user_id' => $user_model->getInsertID(), 'code' => $code]);
            return $this->respondSuccess(['email' => $register_data['email']]);
        }
        return $this->respondErrors(['email' => 'Не удалось отправить код подтверждения']);
    }

    public function verifyEmail()
    {
        $verify_data = request()->getPost();

        if (!$this->validateData($verify_data, 'verify_email')) {
            return $this->respondErrors($this->validator->getErrors());
        }

        $user_model = new UserModel;
        $user = $user_model->where('email', $verify_data['email'])->first();
        if (!$user) {
            return $this->respondErrors(['email' => 'Пользователь не найден']);
        }

        $db = \Config\Database::connect();

        if ($user['is_verified']) {
            return $this->respondErrors(['email' => 'Почта уже подтвержденна']);
        }
        $res = $db->table('email_verifications')
            ->where('user_id', $user['id'])
            ->where('code', $verify_data['code'])
            ->get()
            ->getFirstRow();
        if ($res) {
            $user_model = new UserModel;
            $user_model->update($user['id'], ['is_verified' => 1]);
            $db->table('email_verifications')->delete(['user_id' => $user['id']]);

            helper('jwt');
            $token = getSignedJWTForUser($user['id']);
            return $this->respondSuccess(['token' => $token]);
        }
        return $this->respondErrors(['code' => 'Неверный код подтверждения']);
    }

    public function login()
    {
        $login_data = request()->getPost();

        if (!$this->validateData($login_data, 'login')) {
            return $this->respondErrors($this->validator->getErrors())->setHeader('Access-Control-Allow-Origin','*');
        }
        $user_model = new UserModel;
        $user = $user_model->where('email', $login_data['email'])->first();
        if (!$user) {
            return $this->respondErrors(['email' => 'Пользователь с таким email не зарегистрирован']);
        }
        if (!password_verify($login_data['password'], $user['password'])) {
            return $this->respondErrors(['password' => 'Неверный пароль'])->setHeader('Access-Control-Allow-Origin','*');
        }

        helper('jwt');
        $token = getSignedJWTForUser($user['id']);
        return $this->respondSuccess(['token' => $token]);
    }
}
