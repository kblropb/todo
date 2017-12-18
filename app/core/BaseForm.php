<?php

namespace app\core;

abstract class BaseForm
{
    public $response;

    public function __construct()
    {
        $this->response = new BaseResponse();
    }

    abstract public function process($formData = []);
}