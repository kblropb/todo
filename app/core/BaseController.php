<?php

namespace app\core;

class BaseController
{
    const SUCCESS = 'Successful';
    const CAN_LOG_IN = 'Now you can log in';

    const ERROR_WRONG_TASK_ID = 'Wrong task Id';
    const ERROR_WRONG_TITLE = 'Title can not be empty';
    const ERROR_WRONG_NAME = 'Name can not be empty';
    const ERROR_WRONG_CONTENT = 'Content can not be empty';
    const ERROR_WRONG_DATE = 'Wrong date';
    const ERROR_WRONG_LABEL = 'Wrong label';
    const ERROR_WRONG_EMAIL = 'Wrong email';
    const ERROR_WRONG_PASSWORD = 'Wrong password';
    const ERROR_WRONG_USER_OR_PASSWORD = 'User not wound or wrong password';

    const ERROR_MUST_LOG_IN = 'You must login';

    const PAGE_NOT_FOUND = 'Page not found';

    protected $model;

    public function __call($name, $arguments)
    {
        $data = [
            'title' => self::PAGE_NOT_FOUND,
            'content' => self::PAGE_NOT_FOUND
        ];

        $this->sendErrorAction($data,'404.php');
    }

    public function indexAction(BaseRequest $request)
    {
    }

    /**
     * @param array $data
     * @param $contentTemplate
     * @param $pageTemplate
     * @return string
     */
    public function renderTemplate($data = [], $contentTemplate = 'BaseContentTemplate.php', $pageTemplate = 'BasePageTemplate.php')
    {
        $pageTemplate = 'app\view\\' . $pageTemplate;
        $contentTemplate = 'app\view\\' . $contentTemplate;


        if (!file_exists($pageTemplate)) {
            $pageTemplate = 'app\view\BasePageTemplate.php';
        }

        // included in $pageTemplate
        if (!file_exists($contentTemplate)) {
            $contentTemplate = 'app\view\BaseContentTemplate.php';
        }

        if (is_array($data)) {
            extract($data);
        }

        include $pageTemplate;
    }

    /**
     * @param array $data
     * @param string $contentTemplate
     */
    public function renderContent($data = [], $contentTemplate = 'BaseContentTemplate.php')
    {
        $contentTemplate = 'app\view\\' . $contentTemplate;
        if (is_array($data)) {
            extract($data);
        }
        if (!file_exists($contentTemplate)) {
            $contentTemplate = 'app\view\BaseContentTemplate.php';
        }
        include $contentTemplate;
    }

    /**
     * @return int
     */
    protected function isLoggedIn()
    {
        session_start();
        return isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
    }

    /**
     * @param array $data
     * @param string $contentTemplate
     */
    public function sendErrorAction($data, $contentTemplate)
    {
        $this->renderContent($data, $contentTemplate);
    }

    public function redirectToFrontpage()
    {
        header("Location: login");
        exit();
    }

}