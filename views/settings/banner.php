<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 26.05.2015
 * Time: 17:00
 */
use rere\core\widgets\ActiveForm;

?>

<div class="row">
    <div class="column">

        <h1>Редактирование баннера</h1>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <?= $form->field($model, 'link')->input('url') ?>

        <div class="row">
            <div class="columns medium-3">
                <?= $form->field($model, 'file_vertical')->fileInput()->label($model->banner('vertical')) ?>
            </div>
            <div class="columns medium-9">
                <?= $form->field($model, 'file_horizontal')->fileInput()->label($model->banner('horizontal')) ?>
            </div>
        </div>

        <button class="button" type="submit">сохранить</button>

        <?php ActiveForm::end(); ?>

    </div>
</div>
