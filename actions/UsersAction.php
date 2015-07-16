<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.07.2015
 * Time: 16:24
 */

namespace rere\admin\actions;


use rere\user\models\User;
use Yii;
use yii\base\Action;
use yii\data\ActiveDataProvider;

/**
 * @property \rere\admin\controllers\SettingsController $controller
 */
class UsersAction extends Action
{
    public function run()
    {
        $model = new User;
        $dataProvider = new ActiveDataProvider([
            'query' => $model::find(),
        ]);
        $this->controller->typicalActions($model, Yii::$app->request->get());
        return $this->controller->render($this->id, compact('dataProvider'));
    }

}