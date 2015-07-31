<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.07.2015
 * Time: 17:04
 */

namespace rere\admin\actions;


use rere\core\models\Module;
use Yii;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class ModulesAction extends Action
{
    /**
     * @param null|string $do
     * @param null|number $id
     * @return string
     */
    public function run($do = null, $id = null)
    {
        $model = new Module();
        $dataProvider = new ActiveDataProvider([
            'query' => $model::find(),
        ]);
        if ($do) {
            $function = 'do' . ucfirst($do);
            return $this->{$function}($model, $id);
        }

        return $this->controller->render($this->id, ['dataProvider' => $dataProvider]);
    }

    /**
     * @param $model ActiveRecord
     * @param null|number $id
     * @return string
     */
    public function doForm($model, $id = null)
    {
        if ($id) $model = $model->findOne($id);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->controller->redirect(Yii::$app->request->get('back', [null]));
            }
        }

        return $this->controller->render('moduleForm', ['model' => $model]);
    }

    /**
     * @param $model ActiveRecord
     * @param number $id
     * @return string
     */
    public function doDelete($model, $id)
    {
        $model->deleteAll(['id'=>$id]);
        return $this->controller->redirect(Yii::$app->request->get('back', [null]));
    }

}