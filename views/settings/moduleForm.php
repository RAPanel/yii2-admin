<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 30.07.2015
 * Time: 15:49
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="row">
    <div class="column">
        <h1>Управление Модулем</h1>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'url')->textInput() ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'settings[photos]')->textInput(['type'=>'number'])->label('Photo Count') ?>
        <?= $form->field($model, 'settings[photosTypes]')->textInput(['type'=>'text'])->label('Photo Types') ?>
        <?= $form->field($model, 'settings[characters]')->checkbox(['label'=>'Show Characters']) ?>
        <?= $form->field($model, 'settings[data]')->checkbox(['label'=>'Show Data']) ?>
        <?= $form->field($model, 'settings[seo]')->checkbox(['label'=>'Show Seo']) ?>
        <?= $form->field($model, 'settings[position]')->checkbox(['label'=>'Show Position']) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app.labels', 'Create') : Yii::t('app.labels', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>