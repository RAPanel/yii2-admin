<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 26.05.2015
 * Time: 17:00
 *
 * @var $models array
 */
use rere\core\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="row">
    <div class="column">

        <div class="right">
            <br>
            <button type="button" class="button success tiny" onclick="addByTemplate()">+ добавить значение</button>
        </div>

        <h1>Параметры сайта</h1>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <?
        /**
         * @var int $key
         * @var \rere\core\defaultModels\Settings $model
         */
        foreach ($models as $key => $model) {
            $type = $model->inputType;
            ?>
            <div class="row">
                <?= Html::hiddenInput("Settings[{$key}][id]", $model->id) ?>

                <div class="small-3 columns">
                    <?= Html::label(Html::tag('sup', $model->path) . " {$model->name}", "input{$key}", ['class' => 'right inline']) ?>
                </div>

                <? if ($model->inputType == 'file' && $model->value): ?>
                    <div class="small-5 columns">
                        <?= Html::a(basename($model->value), $model->value, ['target' => '_blank']); ?>
                        <?= Html::button('&times;', ['class' => 'tiny alert', 'onclick' => 'clearValue(this)']);; ?>
                    </div>
                    <? $columns = 4; ?>

                <? elseif ($model->inputType == 'photo' && $model->value): ?>
                    <div class="small-5 columns">
                        <?= Html::a(Html::img($model->value), $model->value, ['target' => '_blank']); ?>
                        <?= Html::button('&times;', ['class' => 'tiny alert', 'onclick' => 'clearValue(this)']);; ?>
                    </div>
                    <? $type = 'file'; ?>
                    <? $columns = 4; ?>
                <? endif ?>

                <div class="small-<?= isset($columns) ? $columns : 9 ?> columns">
                    <?
                    if ($model->inputType == 'textarea')
                        echo Html::textarea("Settings[{$key}][value]", $model->value, ['id' => "input{$key}", 'rows' => 2]);
                    else
                        echo Html::input($model->inputType, "Settings[{$key}][value]", $model->value, ['id' => "input{$key}"]);
                    ?>
                </div>
            </div>

            <? if (isset($columns)) unset($columns); ?>
        <? } ?>

        <div id="template" class="hide" data-key="<?= isset($key) ? $key + 1 : 0 ?>">
            <div class="row">
                <div class="small-3 columns">
                    <?= Html::input('text', "Settings[XXX][name]", null, ['placeholder' => 'Наименование', 'disabled' => true]) ?>
                </div>
                <div class="small-5 columns">
                    <?= Html::input('text', "Settings[XXX][value]", null, ['placeholder' => 'Значение', 'disabled' => true]) ?>
                </div>
                <div class="small-2 columns">
                    <?= Html::input('text', "Settings[XXX][path]", null, ['placeholder' => 'Путь для сайта', 'disabled' => true]) ?>
                </div>
                <div class="small-2 columns">
                    <?= Html::input('text', "Settings[XXX][inputType]", 'text', ['placeholder' => 'Тип поля', 'disabled' => true]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="small-9 small-offset-3 columns">
                <button class="button" type="submit">сохранить</button>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<script>
    function addByTemplate() {
        var t = $('#template'), el = t.clone();
        $('input', el).prop('disabled', false).each(function () {
            $(this).attr('name', $(this).attr('name').replace('XXX', el.data('key')));
        });
        t.before(el.html());
        t.attr('data-key', parseInt(el.data('key')) + 1);
    }
    function clearValue(el) {
        var block = $(el).parents('.columns').next().addClass('small-9');
        $(el).parents('.columns').remove();
        var input = $('input', block);
        input.before('<input type="hidden" name="' + input.attr('name') + '" value="">');
    }
</script>
