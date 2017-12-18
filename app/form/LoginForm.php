<?php

namespace app\form;


use app\core\BaseController;
use app\core\BaseForm;
use app\model\UserModel;

class LoginForm extends BaseForm
{
    /**
     * @param array $formData
     * @return \app\core\BaseResponse
     */
    public function process($formData = [])
    {
        $this->response->success = true;

        if (empty($formData['email']) || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_EMAIL;
        } else {
            $this->response->data['email'] = addslashes($formData['email']);
        };

        if (empty($formData['password'])) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_PASSWORD;
        } else {
            $this->response->data['password'] = addslashes($formData['password']);
        };

        $model = new UserModel();
        $user = $model->getUser($this->response->data['email']);
        if (!$user || $user['password'] !== md5($this->response->data['password'])) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_USER_OR_PASSWORD;
        } else {
            unset($this->response->data['password']);
            $this->response->data['userId'] = $user['id'];
        }

        return $this->response;
    }
}