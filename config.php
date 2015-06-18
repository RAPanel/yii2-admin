<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.03.2015
 * Time: 18:40
 */

return [
    'defaultRoute' => 'structure',
    'layout' => 'index',
    'components' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
        ],
        // список конфигураций компонентов
    ],
    'params' => [
    ],
];