<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.04.2015
 * Time: 19:02
 */
use yii\helpers\Html;

$options = [];

if (empty($data)) {
    $data = new \rere\core\models\Photo();
    $data->id = 'XXX';
    $options['disabled'] = true;
}
?>

<div class="image panel" id="photo<?= $data->id ?>" style="<? if ($data->isNewRecord) echo 'display:none' ?>">
    <? if (!$data->isNewRecord) echo Html::hiddenInput(Html::getInputName($data, "[{$data->id}]id"), $data->id, $options) ?>
    <div class="row">
        <div class="medium-5 column photo">
            <?= Html::img($data->getFile()) ?>
        </div>
        <div class="medium-7 column right text">
            <div class="row">
                <div class="medium-4 column size"><span class="width"><?= $data->width ?></span> x <span
                        class="height"><?= $data->height ?></span></div>
                <div class="medium-7 column type"><?=
                    Html::dropDownList(Html::getInputName($data, "[{$data->id}]type"), $data->type, $types, $options) ?></div>
                <div class="medium-1 column close"><?=
                    Html::button('&#215;', ['class' => 'button alert small expand', 'onclick' => "var photo = $(this).parents('.image');$.get('photo-delete', {id:photo.attr('id').replace('photo', '')},function(){photo.remove()})"]) ?></div>
            </div>
            <?= Html::textarea(Html::getInputName($data, "[{$data->id}]about"), $data->about, $options + ['rows' => 4]) ?>
            <div class="name"></div>
        </div>
        <?= Html::hiddenInput(Html::getInputName($data, "[{$data->id}]name"), $data->name, $options) ?>
        <?= Html::hiddenInput(Html::getInputName($data, "[{$data->id}]sort_id"), $data->sort_id, $options) ?>
    </div>
</div>
