<?php

namespace app\controller;


use app\core\BaseController;
use app\core\BaseRequest;

class FrontpageController extends BaseController
{
    public function indexAction(BaseRequest $request)
    {
        $data = [
            'title' => 'Simple TODO',
            'content' => 'Base content',
            'addUserUrl' => '/user/add',
            'loginUrl' => '/user/login',
            'addTaskUrl' => '/task/add',
            'taskListUrl' => '/task/list',
            'taskRemoveUrl' => '/task/remove',
            'userId' => $this->isLoggedIn()
        ];
        return $this->renderTemplate($data);
    }
}