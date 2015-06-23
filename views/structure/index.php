<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.03.2015
 * Time: 18:45
 */
use rere\core\models\Page;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;


$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => Page::find()->where('parent_id=:id', ['id' => Yii::$app->request->get('id')]),
    'pagination' => [
        'pageSize' => 10,
    ],
]);

$links = [];
$query = Page::find()->orderBy('id');
$query->where('id=:id', [':id' => Yii::$app->request->get('id')]);
if ($idList = Page::find()->where('id=:id', [':id' => Yii::$app->request->get('id')])->select('parent_id')->scalar())
    $query->orWhere('id IN(' . $idList . ')');
$list = $query->all();
foreach ($list as $page) {
    if ($page->id == Yii::$app->request->get('id')) Yii::$app->params['goTopId'] = $page->parent_id;
    $links[] = ['label' => $page->name, 'url' => Yii::$app->request->get('id') == $page->id ? null : ['index', 'id' => $page->id]];

}
?>

<div class="row">
    <div class="column">

        <h1>Управляем структурой</h1>

        <?= Html::a('+', ['edit/index', 'parent' => Yii::$app->request->get('id')], ['class' => 'button right tiny success']) ?>

        <?= Breadcrumbs::widget([
            'options' => ['class' => 'breadcrumbs'],
            'homeLink' => false,
            'links' => $links,
        ]); ?>

        <?= \yii\grid\GridView::widget([
            'tableOptions' => ['style' => 'width:100%'],
            'dataProvider' => $dataProvider,
            'beforeRow' => function ($data, $id, $i, $grid) {
                if ($i == 0 && !empty(Yii::$app->params['goTopId']))
                    return '<tr><td colspan="2"></td><td colspan="4">' . Html::a('... [up]', ['structure/index', 'id' => Yii::$app->params['goTopId']]) . '</td></tr>';
                return false;
            },
            'afterRow' => function ($data, $id, $i, $grid) {
                if ($grid->dataProvider->count == $i + 1)
                    return '<tr><td colspan="2"></td><td colspan="4">' . Html::a('+++ [add]', ['edit/index', 'parent' => $data->parent_id]) . '</td></tr>';
                return false;
            },
            'columns' => [
                ['class' => CheckboxColumn::className()],
                'id',
                [
                    'attribute' => 'photo',
                    'content' => function ($data) {
                        return $data->photo ? Html::img($data->photo->getHref('40x40')) : null;
                    }
                ],
                [
                    'attribute' => 'name',
                    'content' => function ($data) {
                        return $data->with_child ? Html::a($data->name, ['structure/index', 'id' => $data->id]) : $data->name;
                    }
                ],
                'about',
                'created_at:date',
                [
                    'class' => ActionColumn::className(),
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return ($model->url && $model->href) ? Html::a('View', $model->href, ['target' => '_blank']) : null;
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('Update', $url);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', $url);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') $action = 'edit/index';
                        return Url::to([$action, 'id' => $key, 'back' => Yii::$app->request->url]);
                    }
                ],
            ],
        ]) ?>

        <? /*= JqGridWidget::widget([
            'requestUrl' => Url::toRoute('jqgrid'),
            'gridSettings' => [
                'colNames' => ['Title', 'Author', 'Language'],
                'colModel' => [
                    ['name' => 'name', 'index' => 'name', 'editable' => true],
                    ['name' => 'about', 'index' => 'about', 'editable' => true],
                    ['name' => 'created', 'index' => 'created', 'editable' => true]
                ],
                'rowNum' => 15,
                'autowidth' => true,
                'height' => 'auto',
            ],
            'pagerSettings' => [
                'edit' => true,
                'add' => true,
                'del' => true,
                'search' => ['multipleSearch' => true]
            ],
            'enableFilterToolbar' => false,
        ]) */ ?>


    </div>

</div>