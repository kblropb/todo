<?php

namespace app\core;


class BaseRequest
{
    /** @var array $post */
    public $post = [];

    public function __construct()
    {
        $this->post = $_POST;
    }

}