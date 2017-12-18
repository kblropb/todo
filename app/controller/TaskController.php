<?php

namespace app\controller;

use app\core\BaseController;
use app\core\BaseRequest;
use app\core\BaseResponse;
use app\form\AddTaskForm;
use app\model\TaskModel;

class TaskController extends BaseController
{
    const LABEL_NEW = 0;
    const LABEL_IN_PROGRESS = 1;
    const LABEL_DONE = 2;

    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        /** @var TaskModel model */
        $this->model = new TaskModel();
    }


    /**
     * @return array
     */
    private function getLabels()
    {
        return [
            self::LABEL_NEW => 'New',
            self::LABEL_IN_PROGRESS => 'In Progress',
            self::LABEL_DONE => 'Done'
        ];
    }

    /**
     * view add form
     */
    public function addAction()
    {
        $userId = $this->isLoggedIn();

        if (!$userId) {
            $this->renderContent([], 'MustLogin.php');
        } else {
            $data = [
                'labels' => $this->getLabels(),
                'putTaskUrl' => '/task/put'
            ];
            $this->renderContent($data, 'AddTaskForm.php');
        }
    }

    /**
     * add or update task
     * @param BaseRequest $request
     * @return string (json)
     */
    public function putAction(BaseRequest $request)
    {
        $formData = $request->post;
        $formData['userId'] = $this->isLoggedIn();
        $formData['availableLabels'] = $this->getLabels();

        $addTaskForm = new AddTaskForm();
        /** @var BaseResponse $response */
        $response = $addTaskForm->process($formData);

        if (!$response->success) {
            return $response->success;
        }

        if (empty($request->post['taskId'])) {
            $response->success = $this->model->addTask($response->data);
        } else {
            $response->data['taskId'] = intval($request->post['taskId']);
            if ($this->model->getTask($response->data)) {
                $response->success = $this->model->updateTask($response->data);
            } else {
                $response->success = false;
                $response->message[] = self::ERROR_WRONG_TASK_ID;
            }
        }

        if ($response->success) {
            $response->message = [self::SUCCESS];
        }

        return $response->getResponse();
    }

    /**
     * @return string (json)
     */
    public function listAction()
    {
        $response = new BaseResponse();
        $response->success = true;
        $userId = $this->isLoggedIn();
        if (!$userId) {
            $response->success = false;
            $response->message[] = self::ERROR_MUST_LOG_IN;
            return $response->getResponse();
        }

        $response->data = $this->model->getTaskList($userId);

        return $response->getResponse();
    }

    /**
     * @param BaseRequest $request
     * @return bool
     */

    /**
     * @param BaseRequest $request
     * @return string
     */
    public function removeAction(BaseRequest $request)
    {
        $response = new BaseResponse();
        $response->success = true;
        $userId = $this->isLoggedIn();
        if (!$userId) {
            $response->success = false;
            $response->message[] = self::ERROR_MUST_LOG_IN;
        }

        if (empty($request->post['taskId'])) {
            $response->success = false;
            $response->message[] = self::ERROR_WRONG_TASK_ID;
        }

        if (!$response->success) {
            return $response->getResponse();
        }
        $taskId = intval($request->post['taskId']);
        $response->success = $this->model->removeTask($taskId, $userId);

        if ($response->success) {
            $response->message = self::SUCCESS;
        }

        return $response->getResponse();
    }

}