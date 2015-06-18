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

        <h1>Система замен для сайта</h1>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <?
        /**
         * @var int $key
         * @var \rere\core\defaultModels\Settings $model
         */
        foreach ($models as $key => $model) {
            ?>
            <div class="row">
                <?= Html::hiddenInput("Replaces[{$key}][name]", $model->name) ?>

                <div class="small-3 columns">
                    <?= Html::label("{{{$model->name}}}", "input{$key}", ['class' => 'right inline']) ?>
                </div>
                <div class="small-9 columns">
                    <?
                    //@todo Uncomment
                    /*= devgroup\ace\Ace::widget([
                        'id' => "input{$key}",
                        'name' => "Replaces[{$key}][value]", // editor name
                        'value' => $model->value, // editor default value
                        'options' => ['rows' => 5], // html options
                        'theme' => 'github', // editor theme
                        'mode' => 'php', // editor mode
                    ]);*/ ?>
                </div>
            </div>

            <? if (isset($columns)) unset($columns); ?>
        <? } ?>

        <div id="template" class="hide" data-key="<?= isset($key) ? $key + 1 : 0 ?>">
            <div class="row">
                <div class="small-3 columns">
                    <?= Html::input('text', "Replaces[XXX][name]", null, ['placeholder' => 'Наименование', 'disabled' => true]) ?>
                </div>
                <div class="small-9 columns">
                    <? /*= trntv\aceeditor\AceEditor::widget([
                        'name' => "Replaces[XXX][value]",
                        'value' => '',

                        'mode'=>'php',
                        'theme'=>'github',
                    ]);*/ ?>
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
    function clearValue(e) {
        var block = $(el).parents('.columns').next().addClass('small-9');
        $(el).parents('.columns').remove();
        var input = $('input', block);
        input.before('<input type="hidden" name="' + input.attr('name') + '" value="">');
    }
</script>
