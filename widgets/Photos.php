<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 14.04.2015
 * Time: 9:38
 */

namespace rere\admin\widgets;


use rere\core\widgets\DropZoneAsset;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class Photos extends InputWidget
{
    public $types = [];

    public function run()
    {
        $result = '';
        $result .= Html::beginTag('div', ['class' => 'dropzone', 'action' => '/']);
        $result .= Html::tag('div', Html::activeFileInput($this->model, $this->attribute, ['class' => 'tags']), ['class' => 'fallback']);
        $result .= Html::endTag('div');

        DropZoneAsset::register($this->view);
        $this->view->registerJs('dropzone', '$(".dropzone").dropzone();');

        return $result;
    }

}