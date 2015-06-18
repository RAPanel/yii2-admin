<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.03.2015
 * Time: 18:45
 *
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use yii\widgets\Menu;

//use rere\core\widgets\jstree\JsTree;

\rere\core\widgets\foundation\FoundationAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>

<style>
    .f-dropdown li a {
        padding: 0;
        display: inline
    }

    .jstree-container-ul {
        display: block;
        width: 100%;
        max-height: 500px;
        overflow: auto;
    }

    .hidden {
        display: none
    }

    .ace_editor {
        margin-bottom: 1.5em;
    }

    ul.ui-front {
        z-index: 10000;
    }
</style>

<?php
$this->registerJs(<<<JS
$(function(){
        jQuery('#w1').on('click', "a.jstree-anchor", function (event) {
        location.href = 'index?id='+event.target.id.replace('_anchor', '')
        });
    })
JS
)

?>

<div class="sticky">
    <nav class="top-bar" data-topbar role="navigation">
        <section class="top-bar-section">
            <a class="right button" style="margin-right: 0.5rem" data-dropdown="map" aria-controls="map"
               aria-expanded="false">Карта</a>
            <? echo Menu::widget(['items' => [
                ['label' => 'Структура', 'url' => ['structure/index', 'id' => Yii::$app->request->get('id')], 'options' => ['class' => 'structure']],
                ['label' => 'Редактирование', 'url' => ['edit/index', 'id' => Yii::$app->request->get('id')], 'options' => ['class' => 'edit']],
                ['label' => 'Управление', 'url' => ['settings/index'], 'options' => ['class' => 'settings']],
            ]]); ?>
        </section>
    </nav>

    <div id="map" data-dropdown-content class="f-dropdown medium" aria-hidden="true" aria-autoclose="false"
         tabindex="-1">
        <!--        --><? //= JsTree::widget(['clientOptions' => [
        //            'core' => [
        //                'data' => [
        //                    'url' => Url::to(['structure/tree']),
        //                    'data' => new JsExpression('function (node) {return { "id" : node.id };}')
        //                ]
        //            ],
        //            /*"massload" => [
        //                "url" => Url::to(['structure/tree']),
        //                "data" => new JsExpression('function (nodes) {return { "ids" : nodes.join(",") };}')
        //            ],*/
        //            "plugins" => ["massload", "state", 'wholerow'],
        //        ]]) ?>
    </div>
</div>

<? echo $content; ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>

