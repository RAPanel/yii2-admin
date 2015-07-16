<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.07.2015
 * Time: 16:24
 */

namespace rere\admin\actions;


use Yii;
use yii\base\Action;

class BannerAction extends Action
{
    public function run()
    {
        $model = BannerData::find();
        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post($model->formName());
            $model->save();
            $this->controller->refresh();
        }
        return $this->controller->render($this->id, compact('model'));
    }

}