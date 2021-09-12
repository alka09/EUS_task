<?php

namespace app\tasks\useCases;

use app\tasks\entities\Tasks;
use app\tasks\forms\PhotosForm;
use app\tasks\forms\TaskForm;
use app\tasks\repositories\TaskRepository;

class TaskManageService
{
    private $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->tasks = $tasks;
    }

    public function create(TaskForm $form): Tasks
    {
        $task = Tasks::create(
            $form->user_id,
            $form->title
        );

        foreach ($form->photos->files as $file) {
            $task->addPhoto($file);
        }

        $this->tasks->save($task);
        return $task;
    }

    public function edit($id, TaskForm $form): void
    {
        $task = $this->tasks->get($id);
        $task->edit(
            $form->title
        );

        $this->tasks->save($task);
    }

    public function addPhotos($id, PhotosForm $form): void
    {
        $task = $this->tasks->get($id);
        foreach ($form->files as $file) {
            $task->addPhoto($file);
        }
        $this->tasks->save($task);


    }

    public function movePhotoUp($id, $photoId): void
    {
        $task = $this->tasks->get($id);
        $task->movePhotoUp($photoId);
        $this->tasks->save($task);
    }

    public function movePhotoDown($id, $photoId): void
    {
        $task = $this->tasks->get($id);
        $task->movePhotoDown($photoId);
        $this->tasks->save($task);
    }

    public function removePhoto($id, $photoId): void
    {
        $task = $this->tasks->get($id);
        $task->removePhoto($photoId);
        $this->tasks->save($task);
    }

    public function remove($id): void
    {
        $task = $this->tasks->get($id);
        $this->tasks->remove($task);
    }
}