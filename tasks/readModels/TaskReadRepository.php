<?php

namespace app\tasks\readModels;


use app\tasks\entities\Tasks;

class TaskReadRepository
{
    public function find($id): ? Tasks
    {
        return Tasks::findOne($id);
    }

}