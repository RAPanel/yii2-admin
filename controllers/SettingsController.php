<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.05.2015
 * Time: 0:50
 */

namespace rere\admin\controllers;


use app\models\BannerData;
use app\models\User;
use rere\core\defaultModels\Replaces;
use rere\core\defaultModels\Settings;
use rere\core\models\PageComments;
use rere\core\widgets\fileManager\FileManager;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class SettingsController extends Controller
{

    public function actionIndex()
    {
        $actions = [
            'params' => 'Параметры и настройки',
            'replaces' => 'Список замен в редакторе',
            'users' => 'Список пользователей сайта',
            'comments' => 'Все комментарии на сайте',
            'banner' => 'Управление баннером на сайте',
//            'file' => 'Коммерческое предложение',
//            'file-manager' => 'Менеджер для управления файлами',
        ];
        return $this->render($this->action->id, compact('actions'));

    }

    public function actionParams()
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
            $this->refresh();
        }

        return $this->render($this->action->id, compact('models'));
    }

    public function actionReplaces()
    {
        $models = Replaces::find()->all();

        if (Yii::$app->request->isPost) {
            foreach (Yii::$app->request->post(reset($models)->formName()) as $key => $row) {
                if (isset($row['name']) && isset($row['value'])) {
                    foreach ($models as $model)
                        if ($model->name == $row['name']) {
                            $model->setAttributes($row);
                            $model->save(false);
                        }
                } else {
                    $model = new Replaces();
                    $model->setAttributes($row);
                    $model->save(false);
                }
            }
            $this->refresh();
        }

        return $this->render($this->action->id, compact('models'));
    }

    public function actionUsers()
    {
        $model = new User;
        $dataProvider = new ActiveDataProvider([
            'query' => $model::find(),
        ]);
        $this->typicalActions($model, Yii::$app->request->get());
        return $this->render($this->action->id, compact('dataProvider'));
    }

    /** @var ActiveRecord $model
     * @return array|void
     */
    public function typicalActions($model, $params)
    {
        if (empty($params['action'])) return false;
        if ($params['action'] == 'delete' && $params['id']) {
            $model::findOne($params['id'])->delete();
            return $this->redirect($params['back'] ? $params['back'] : Yii::$app->request->referrer);
        }
        return false;
    }

    public function actionComments()
    {
        $model = new PageComments;
        $dataProvider = new ActiveDataProvider([
            'query' => $model::find(),
        ]);

        $this->typicalActions($model, Yii::$app->request->get());

        return $this->render($this->action->id, compact('dataProvider'));
    }

    public function actionBanner()
    {
        $model = BannerData::find();
        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post($model->formName());
            $model->save();
            $this->refresh();
        }
        return $this->render($this->action->id, compact('model'));
    }

    public function actionFile()
    {
        $model = BannerData::find();
        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post($model->formName());
            $model->save();
            $this->refresh();
        }
        return $this->render($this->action->id, compact('model'));
    }

    public function actionFileManager()
    {
        echo FileManager::widget();
    }
}