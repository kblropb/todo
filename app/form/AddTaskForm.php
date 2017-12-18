<?php
/**
 * Created by PhpStorm.
 * User: Zhdanovich Igor
 * Date: 14.12.2017
 * Time: 20:50
 */

namespace app\form;


use app\core\BaseController;
use app\core\BaseForm;

class AddTaskForm extends BaseForm
{
    public function process($formData = [])
    {

        $this->response->success = true;

        if (!$formData['userId']) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_MUST_LOG_IN;
        } else {
            $this->response->data['userId'] = $formData['userId'];
        }

        if (empty($formData['taskTitle'])) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_TITLE;
        } else {
            $this->response->data['title'] = htmlentities($formData['taskTitle']);
        }

        if (empty($formData['taskContent'])) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_CONTENT;
        } else {
            $this->response->data['content'] = htmlentities($formData['taskContent']);
        }

        if (
            empty($formData['taskDate'])
            || !\DateTime::createFromFormat('Y-m-d H:i:s', $formData['taskDate'])
            || new \DateTime($formData['taskDate']) < new \DateTime('now')
        ) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_DATE;
        } else {
            $taskDate = new \DateTime($formData['taskDate']);
            $this->response->data['date'] = $taskDate->format('Y-m-d H:i:s');
        }

        if (!isset($formData['taskLabel']) || !array_key_exists(intval($formData['taskLabel']), $formData['availableLabels'])) {
            $this->response->success = false;
            $this->response->message[] = BaseController::ERROR_WRONG_LABEL;
        } else {
            $this->response->data['label'] = intval($formData['taskLabel']);
        }

        return $this->response;
    }

}