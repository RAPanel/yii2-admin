<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 26.05.2015
 * Time: 11:12
 *
 * @var $this \yii\web\View
 */
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

?>


<div class="row">
    <div class="column">

        <h1>Список модулей</h1>

        <?= Html::a('add', [null, 'do' => 'form']) ?>

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
                'url',
                'name',
                'created_at:datetime',
                [
                    'class' => ActionColumn::className(),
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('Update', $url);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('Delete', $url);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if($action == 'update') $action = 'form';
                        return Url::to([null, 'do' => $action, 'id' => $model->id, 'back' => Yii::$app->request->url]);
                    }
                ],
            ],
        ]) ?>


    </div>

</div>