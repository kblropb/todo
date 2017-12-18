<?php

namespace app\controller;

use app\core\BaseController;
use app\core\BaseRequest;
use app\core\BaseResponse;
use app\form\LoginForm;
use app\form\UserForm;
use app\model\UserModel;

class UserController extends BaseController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * @param BaseRequest $request
     * @return string
     */
    public function addAction(BaseRequest $request)
    {
        $userForm = new UserForm();
        /** @var BaseResponse $response */
        $response = $userForm->process($request->post);

        if ($response->success) {
            $response->success = $this->model->addUser($response->data);
        };

        if ($response->success) {
            $response->message = [self::CAN_LOG_IN];
        };

        return $response->getResponse();
    }

    /**
     * @param BaseRequest $request
     * @return string
     */
    public function loginAction(BaseRequest $request)
    {
        $loginForm = new LoginForm();
        $response = $loginForm->process($request->post);

        if (!$response->success) {
            return $response->getResponse();
        }

        session_start();
        $_SESSION['userId'] = $response->data['userId'];
        $_SESSION['userLogin'] = $response->data['email'];

        $response->message = [self::SUCCESS];
        return $response->getResponse();
    }

}