<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.03.2015
 * Time: 18:45
 *
 * @var $base Page
 * @var $view \yii\web\View
 */
use rere\admin\widgets\FormGenerator;
use rere\core\models\Page;
use rere\core\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$selectList = [];
foreach (Yii::$app->params['modules'] as $key => $val) $selectList[$key] = Yii::t('admin.module', $val);
$get = Yii::$app->request->get();
if (isset($get['module_id'])) unset($get['module_id']);

if (!empty($data)):
    ?>
    <div data-alert class="alert-box alert">
        <div class="row"><?= Html::errorSummary($data) ?></div>
        <a href="#" class="close">&times;</a>
    </div>
<? endif ?>


<div class="row">
    <div class="column">

        <?php $form = ActiveForm::begin([
            'id' => $base->formName(),
            'enableClientScript' => false,
            'action' => ['index'] + $get,
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <div class="right medium-2">
            <?= $form->select($selectList, $base, 'module_id', ['onchange' => 'location.href="' . Url::to(['index'] + $get) . '&module_id="+this.value'])->label(false) ?>
        </div>

        <?= FormGenerator::widget([
            'config' => require Yii::getAlias('@rere/' . $selectList[$base->module_id] . '/config/grid.php'),
            'form' => $form,
            'model' => $base,
        ]); ?>

        <?= Html::submitButton('сохранить') ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
