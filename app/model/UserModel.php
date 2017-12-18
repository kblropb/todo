<?php
namespace app\model;


use app\core\BaseModel;

class UserModel extends BaseModel
{

    /**
     * @param $user
     * @return bool
     */
    public function addUser($user)
    {
        $query = "INSERT INTO `user` (`name`, `email`, `password`) 
            VALUES ('" . $user['name'] . "','" . $user['email'] . "','" . md5($user['password']) . "')";
        return mysqli_query($this->dbConnect, $query);
    }

    /**
     * @param $email
     * @return bool
     */
    public function isUniqeEmail($email)
    {
        $query = "SELECT `id` FROM `user` WHERE `email` = '" . $email . "'";
        $result = mysqli_query($this->dbConnect, $query);
        return !$result->num_rows;
    }

    public function getUser($email)
    {
        $query = "SELECT * FROM `user` WHERE `email` = '" . $email . "'";
        $result = mysqli_query($this->dbConnect, $query);
        return mysqli_fetch_assoc($result);

    }
}