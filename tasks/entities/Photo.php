<?php


namespace app\tasks\entities;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $task_id
 * @mixin ImageUploadBehavior
 */
class Photo extends ActiveRecord
{
    public static function create(UploadedFile $file, $task_id): self
    {
        $photo = new static();
        $photo->file = $file;
        $photo->task_id = $task_id;
        return $photo;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName(): string
    {
        return '{{%photos}}';
    }
    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::className(),
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@webroot/images/[[attribute_task_id]]/[[id]].[[extension]]',
                'fileUrl' => '@web/images/[[attribute_task_id]]/[[id]].[[extension]]',
                'thumbPath' => '@webroot/images/cache/[[attribute_task_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@web/images/cache/[[attribute_task_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'file' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 100, 'height' => 70],
                ],
            ],
        ];
    }
}