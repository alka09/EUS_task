<?php

namespace app\controllers;

use app\models\TasksSearch;
use app\tasks\entities\Tasks;
use app\tasks\forms\PhotosForm;
use app\tasks\forms\TaskForm;
use app\tasks\useCases\TaskManageService;
use http\Url;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
{
    private $service;

    public function __construct($id, $module, TaskManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $searchModel->user_id = \Yii::$app->user->id;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView(int $id)
    {

        $task = $this->findModel($id);

        $photosForm = new PhotosForm();
        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()) {

            try {
                $this->service->addPhotos($task->id, $photosForm);
                return $this->redirect(['view', 'id' => $task->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', [
            'task' => $task,
            'photosForm' => $photosForm,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new TaskForm();
        $model = new Tasks();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $task = $this->service->create($form);
                \Yii::$app->user->identity->getId();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate(int $id){
        $task = $this->findModel($id);

        $form = new TaskForm($task);
        if ($form->load(Yii::$app->request->post())  && $form->validate()) {
            try {
                $this->service->edit($task->id, $form);
                return $this->redirect(['view', 'id' => $task->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'task' => $task,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */

    public function actionDelete(int $id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionDeletePhoto(int $id, $photo_id)
    {
        try {
            $this->service->removePhoto($id, $photo_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->service->movePhotoUp($id, $photo_id);
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->service->movePhotoDown($id, $photo_id);
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    /**
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Tasks
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}