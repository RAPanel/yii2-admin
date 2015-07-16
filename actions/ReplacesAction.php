<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.07.2015
 * Time: 16:24
 */

namespace rere\admin\actions;


use rere\core\models\Replaces;
use Yii;
use yii\base\Action;

class ReplacesAction extends Action
{
    public function run(){

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
            $this->controller->refresh();
        }

        return $this->controller->render($this->id, compact('models'));
    }
}