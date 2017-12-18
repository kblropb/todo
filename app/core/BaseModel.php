<?php

namespace app\core;


class BaseModel
{
    protected $dbConnect;

    function __construct()
    {
        $dbHost = "localhost";
        $dbName = "todo";
        $dbUsername = "root";
        $dbPass = "";

        $this->dbConnect = mysqli_connect($dbHost, $dbUsername, $dbPass);
        if (!$this->dbConnect) {
            die ("Can not connect to the database server");
        }

        if (!mysqli_select_db($this->dbConnect, $dbName)) {
            die ('Can not connect to the database' . $dbName);
        }
    }

}