<?php

namespace tests;


use app\controller\TaskController;
use app\core\BaseRequest;
use app\model\TaskModel;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public $request;
    public $taskController;
    public $model;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        require_once __DIR__ . '/../vendor/autoload.php';
        $this->request = new BaseRequest();
        $this->taskController = new TaskController();
        $this->model = new TaskModel();
    }

    /**
     * @runInSeparateProcess
     */
    public function testList()
    {
        session_start();
        $_SESSION['userId'] = 1;
        $responseJson =  $this->taskController->listAction();
        $response = json_decode($responseJson);
        $this->assertTrue($response->success);
    }

    /**
     * @runInSeparateProcess
     */
    public function testNonAuthList()
    {
        $responseJson =  $this->taskController->listAction();
        $response = json_decode($responseJson);
        $this->assertFalse($response->success);
    }
}