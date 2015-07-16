<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.07.2015
 * Time: 16:24
 */

namespace rere\admin\actions;


use rere\core\models\PageComments;
use Yii;
use yii\base\Action;
use yii\data\ActiveDataProvider;


/**
 * @property \rere\admin\controllers\SettingsController $controller
 */
class CommentsAction extends Action
{
    public function run()
    {

        $model = new PageComments;
        $dataProvider = new ActiveDataProvider([
            'query' => $model::find(),
        ]);

        $this->controller->typicalActions($model, Yii::$app->request->get());

        return $this->controller->render($this->id, compact('dataProvider'));
    }

}