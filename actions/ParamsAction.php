<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.07.2015
 * Time: 16:24
 */

namespace rere\admin\actions;


use rere\core\models\Settings;
use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ParamsAction extends Action
{
    public function run()
    {
        $models = Settings::find()->all();

        if (Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post('Settings') as $key => $row) {
                if (isset($row['id'])) {
                    foreach ($models as $model)
                        if ($model->id == $row['id']) {
                            if ($file = UploadedFile::getInstanceByName("Settings[{$key}][value]")) {
                                $dir = '/files/';
                                $row['value'] = $dir . $file->name;
                                $path = Yii::getAlias('@webroot' . $row['value']);
                                FileHelper::createDirectory(Yii::getAlias('@webroot' . $dir));
                                if (file_exists($path)) unlink($path);
                                $file->saveAs($path);
                            }
                            $model->setAttributes($row);
                            $model->save();
                        }
                } else {
                    $model = new Settings();
                    $model->setAttributes($row);
                    $model->save();
                }
            }
            $this->controller->refresh();
        }

        return $this->controller->render($this->id, compact('models'));
    }

}