<?php

namespace app\tasks\repositories;

use app\tasks\entities\Tasks;
use RuntimeException;
use yii\web\NotFoundHttpException;

class TaskRepository
{
    public function get($id): Tasks
    {
        if (!$task = Tasks::findOne($id)) {
            throw new NotFoundHttpException('Page is not found.');
        }
        return $task;
    }

    public function save(Tasks $task): void
    {
        if (!$task->save()) {
            throw new RuntimeException('Saving error');
        }
    }

    public function remove(Tasks $task): void
    {
        if (!$task->delete()) {
            throw new RuntimeException('Removing error');
        }
    }

}