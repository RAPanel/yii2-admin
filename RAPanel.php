<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.03.2015
 * Time: 18:39
 */

namespace rere\admin;

class RAPanel extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        // инициализация модуля с помощью конфигурации, загруженной из config.php
        \Yii::configure($this, require(__DIR__ . '/config.php'));
        \Yii::$app->setModule('user', [
            'class' => 'amnah\yii2\user\Module',
            'modelClasses' => [
                'Role' => 'rere\core\models\Role'
            ],
        ]);
    }
}