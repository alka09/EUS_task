<?php

namespace app\tasks\forms;


use app\tasks\entities\Tasks;
use app\models\User;
use app\tasks\forms\CompositeForm;
use app\tasks\forms\PhotosForm;

/**
 * @property PhotosForm $photos
 */
class TaskForm extends CompositeForm
{

    public $title;
    public $user_id;

    private $_task;

    public function __construct(Tasks $task = null, $config = [])
    {
        $this->user_id = $task->user_id;
        $this->title = $task->title;
        $this->photos = new PhotosForm();
        $this->_task = $task;

        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['title'], 'required'],
            [['title'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    protected function internalForms(): array
    {
        return ['photos'];
    }
}