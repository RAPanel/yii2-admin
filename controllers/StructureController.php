<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.03.2015
 * Time: 18:43
 */

namespace rere\admin\controllers;

use rere\core\models\Character;
use rere\core\models\Page;
use Yii;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\web\Response;

class StructureController extends Controller
{

//    public function actions()
//    {
//        return [
//            'jqgrid' => [
//                'class' => JqGridActiveAction::className(),
//                'model' => Page::className(),
//                'scope' => function ($query) {
//                    /** @var \yii\db\ActiveQuery $query */
//                    $query;
//                },
//            ],
//        ];
//    }

    public function actionIndex($id = null)
    {
        if (empty($id)) {
            $base = Page::findOne(['parent_id' => null]);

            if (is_null($base) && !Page::find()->count()) {
                $base = new Page();
                $base->setAttributes([
                    'url' => '/',
                    'with_child' => '1',
                    'name' => 'Главная',
                ]);
                if (!$base->save())
                    throw new HttpException(404, VarDumper::dumpAsString($base->errors));
            }

            if ($base && $base->id) return $this->redirect(['index', 'id' => $base->id]);
        } else $base = Page::findOne($id);

        if (empty($base)) throw new HttpException(404, Yii::t('rere.error', 'Can`t find page'));
        elseif (!$base->with_child && $base->parent_id) $this->redirect([$this->action->id, 'id' => $base->parent_id]);

        return $this->render($this->action->id);
    }

    public function actionUpdate($id, $back)
    {
        $this->redirect(['edit/index', 'id' => $id, 'back' => $back]);
    }

    public function actionDelete($id, $back)
    {
        Page::findOne($id)->delete();
        $this->redirect($back);
    }

    public function actionTree($id = false, $ids = false)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($id == '#') $id = null;
        $query = Page::find();
        $query->select('t.id, t.parent_id, t.name');
        $query->from(Page::tableName() . ' t');
        $query->joinWith('pages')->addSelect('COUNT(' . Page::tableName() . '.id) AS pagesCount')->groupBy('t.id');
        if ($id !== false) $query->where(['t.parent_id' => $id]);
        elseif ($ids) $query->where(['t.parent_id' => explode(',', $ids)]);
        $list = [];
        foreach ($query->all() as $value) $list[] = [
            'id' => $value->id,
            'parent' => $value->parent_id ? $value->parent_id : '#',
            'text' => $value->name,
            'children' => (bool)$value->pagesCount,
        ];

        return $list;
    }

    public function actionCharactersSearch($term)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Character::find()->select(['url'])->where(['like', 'url', $term . '%', false])->asArray()->column();
    }
}