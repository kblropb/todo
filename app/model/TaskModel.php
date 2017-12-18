<?php

namespace app\model;

use app\core\BaseModel;

class TaskModel extends BaseModel
{
    /**
     * @param array $task
     * @return bool
     */
    public function updateTask($task)
    {
        $query = "UPDATE `task` SET `title` = '" . $task['title'] . "', `date` = '" . $task['date'] . "', `content` = '" . $task['content'] .
            "', `label` = '" . $task['label'] . "'" .
            " WHERE `id` = " . $task['taskId'] . " AND `user_id` = " . $task['userId'];
        return mysqli_query($this->dbConnect, $query);
    }

    /**
     * @param array $task
     * @return bool
     */
    public function addTask($task)
    {
        $query = "INSERT INTO `task` (`title`, `content`, `date`, `label`, `user_id`) 
            VALUES ('" . $task['title'] . "','" . $task['content'] . "','" . $task['date'] . "', '" . $task['label'] . "','" . $task['userId'] . "')";
        return mysqli_query($this->dbConnect, $query);
    }

    /**
     * @param array $task
     * @return array|null
     */
    public function getTask($task)
    {
        $query = "SELECT * FROM `task` WHERE `id` = " . $task['taskId'] . " AND `user_id` = " . $task['userId'];
        $result = mysqli_query($this->dbConnect, $query);
        return mysqli_fetch_assoc($result);
    }

    /**
     * @param $userId
     * @return array|null
     */
    public function getTaskList($userId)
    {
        $query = "SELECT * FROM `task` WHERE `user_id` = " . $userId . " ORDER BY `date` ASC";
        $result = mysqli_query($this->dbConnect, $query);
        $resultArr = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $resultArr[] = $row;
        }
        return $resultArr;
    }

    /**
     * @param $taskId
     * @param $userId
     * @return bool
     */
    public function removeTask($taskId, $userId)
    {
        $query = "DELETE FROM `task` WHERE `id` = " . $taskId . " AND `user_id` = " . $userId;
        return mysqli_query($this->dbConnect, $query);
    }

}