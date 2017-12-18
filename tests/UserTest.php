<?php

namespace app\test;

use app\controller\UserController;
use app\core\BaseRequest;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public $request;
    public $userController;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        require_once __DIR__ . '/../vendor/autoload.php';
        $this->request = new BaseRequest();
        $this->userController = new UserController();
    }

    /**
     * @runInSeparateProcess
     */
    public function testLogin()
    {

        $this->request->post = [
            'email' => 'regreg@tut.by',
            'password' => 1
        ];

        $responseJson = $this->userController->loginAction($this->request);
        $response = json_decode($responseJson);
        $this->assertTrue($response->success);

        return $response;
    }

    public function testInvalidLogin()
    {
        $this->request->post = [
            'email' => 'regreg@tut.by66',
            'password' => 1
        ];

        $responseJson = $this->userController->loginAction($this->request);
        $response = json_decode($responseJson);
        $this->assertFalse($response->success);

        return $response;
    }


}