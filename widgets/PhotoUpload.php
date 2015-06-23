<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.04.2015
 * Time: 18:45
 */

namespace rere\admin\widgets;


use yii\helpers\Html;
use yii\web\JsExpression;

class PhotoUpload extends DropZone
{
    public $types = [];

    public function init()
    {
        $event = <<<JS
function(file, response) {
var block = $('#photoXXX').clone().show().prop('id', 0),
length = '0' + $('.photoWrapper .image').length;
$('.width', block).text(file.width);
$('.height', block).text(file.height);
$('.name', block).text(file.name);
$('[name$="[XXX][name]"]', block).val(response.tmpName);
$('.photo', block).html($('<img>').attr('src', response.tmp)[0]);
$('[name]', block).each(function(){
    $(this).attr('name', $(this).attr('name').replace('XXX', length)).prop('disabled', 0);
});
block.appendTo($('#photoXXX').prevAll('.photoWrapper'));
$('[name$="[sort_id]"]').each(function(key, value){
    $(value).val(key);
});
}

JS;
        $this->clientEvents['success'] = new JsExpression($event);
        parent::init();
    }

    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run()
    {
        $parent = parent::run();
        $content = '';
        $this->value = $this->model->{$this->attribute};
        if (is_array($this->value))
            foreach ($this->value as $index => $data)
                $content .= $this->render('photoTemplate', compact('index', 'data') + ['types' => $this->types]);

        return Html::tag('div', $content, ['class' => 'photoWrapper']) . $parent . $this->render('photoTemplate', ['types' => $this->types]);
    }

}