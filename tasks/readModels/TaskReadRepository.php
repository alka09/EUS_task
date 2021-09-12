<?php

namespace app\tasks\readModels;


use app\tasks\entities\Tasks;

class TaskReadRepository
{
    public static function find($id): ? Tasks
    {
        return Tasks::findOne($id);
    }

}