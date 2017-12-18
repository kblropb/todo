<?php

namespace app\core;


class BaseResponse
{
    /**
     * @var bool
     */
    public $success = false;
    /**
     * @var array
     */
    public $message = [];
    /**
     * @var array
     */
    public $data = [];

    public function getResponse()
    {
        $responseArray = [];

        foreach ($this as $key => $value) {
            $responseArray[$key] = $value;
        }
        return json_encode($responseArray);
    }
}