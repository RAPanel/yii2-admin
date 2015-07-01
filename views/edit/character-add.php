<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 02.06.2015
 * Time: 23:01
 *
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;

$result = '';

$result .= Html::beginForm('', 'post', ['id' => 'characterAddForm']);
$result .= Html::beginTag('div', ['class' => 'row']);
$result .= Html::tag('div', AutoComplete::widget([
    'model' => $model,
    'attribute' => 'url',
    'clientOptions' => [
        'source' => Url::to(['structure/characters-search']),
        'autoFill' => true,
        'minLength' => '0',
    ],
]), ['class' => 'columns']);
$result .= Html::tag('div', Html::activeDropDownList($model, 'type', [
    'text' => 'Текстовая строка [textField]',
    'number' => 'Цена [price]',
    'textarea' => 'Текстовое поле [textArea]',
    'checkbox' => 'Выбор Да/Нет [checkBox]',
]), ['class' => 'columns']);
$result .= Html::tag('div', Html::submitButton('add'), ['class' => 'columns']);
$result .= Html::endTag('div');
$result .= Html::endForm();
$result .= Html::a('&#215;', null, ['class' => "close-reveal-modal", 'aria-label' => "Close"]);
echo $result;

$js = <<<JS
$('#characterAddForm').submit(function(){
    var form = $(this);
    $.post(form.attr('action'), form.serializeArray(), function(data){
        $('.characterList').append(data);
        $('#addCharacter').foundation('reveal', 'close');
    });
    return false;
});
JS;
$this->registerJs($js);
?>


