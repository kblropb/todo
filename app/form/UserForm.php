<?php

namespace app\form;


use app\core\BaseController;
use app\core\BaseForm;
use app\model\UserModel;

class UserForm extends BaseForm
{
    /**
     * @param array $formData
     * @return \app\core\BaseResponse
     */
    public function process($formData = [])
    {
        $model = new UserModel();
        $this->response->success = true;

        if (empty($formData['name'])) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_NAME;
        } else {
            $this->response->data['name'] = addslashes($formData['name']);
        };

        if (
            empty($formData['email'])
            || !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)
            || $model->getUser(addslashes($formData['email']))
        ) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_EMAIL;
        } else {
            $this->response->data['email'] = addslashes($formData['email']);
        };

        if (
            empty($formData['password1'])
            || empty($formData['password2'])
            || $formData['password1'] !== $formData['password2']
        ) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_PASSWORD;
        } else {
            $this->response->data['password'] = addslashes($formData['password1']);
        };

        return $this->response;
    }

}