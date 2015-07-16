<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.05.2015
 * Time: 0:50
 */

namespace rere\admin\controllers;


use app\models\BannerData;
use rere\core\models\PageComments;
use rere\core\models\Replaces;
use rere\core\models\Settings;
use rere\core\widgets\fileManager\FileManager;
use rere\user\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class SettingsController extends Controller
{

    public function actions(){
        $actions = [];
        foreach($this->module->settings as $key => $value)
            $actions[$this->actionName($key)] = $key;
        return $actions;
    }

    public function actionIndex()
    {
        $actions = [];
        foreach($this->module->settings as $key => $value) if($value)
            $actions[$this->actionName($key)] = $value;

        return $this->render($this->action->id, compact('actions'));

    }

    public function actionName($alias){
        $parse = explode("\\", $alias);
        $name = str_replace('Action', '', end($parse));
        return lcfirst($name);
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
}