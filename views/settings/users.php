<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 26.05.2015
 * Time: 10:34
 */
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

?>


<div class="row">
    <div class="column">

        <h1>Список пользователей</h1>

        <?= \yii\grid\GridView::widget([
            'tableOptions' => ['style' => 'width:100%'],
            'dataProvider' => $dataProvider,
            /*'afterRow' => function ($data, $id, $i, $grid) {
                if ($grid->dataProvider->count == $i + 1)
                    return '<tr><td colspan="2"></td><td colspan="4">' . Html::a('+++ [add]', []) . '</td></tr>';
                return false;
            },*/
            'columns' => [
//                ['class' => CheckboxColumn::className()],
                'id',
                [
                    'attribute' => 'photo',
                    'content' => function ($data) {
                        return $data->photo ? Html::img($data->photo->getHref('40x40')) : null;
                    }
                ],
                'username',
                'email',
                'role.name',
                'create_time:datetime',
                /*[
                    'attribute' => 'name',
                    'content' => function ($data) {
                        return $data->with_child ? Html::a($data->name, ['structure/index', 'id' => $data->id]) : $data->name;
                    }
                ],*/
                /*'about',*/
                /*'created',*/
                [
                    'class' => ActionColumn::className(),
                    'buttons' => [
                        /*'view' => function ($url, $model, $key) {
                            return ($model->url && $model->href) ? Html::a('View', $model->href, ['target' => '_blank']) : null;
                        },*/
                        /*'update' => function ($url, $model, $key) {
                            return Html::a('Update', $url);
                        },*/
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', $url);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == 'update') $action = 'edit/index';
                        return Url::to([Yii::$app->controller->action->id, 'action' => $action, 'id' => $key, 'back' => Yii::$app->request->url]);
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
