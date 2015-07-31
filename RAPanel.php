<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.03.2015
 * Time: 18:39
 */

namespace rere\admin;

use Yii;
use yii\helpers\ArrayHelper;

class RAPanel extends \yii\base\Module
{
    public $settings;
    public $modulesConfig;

    public function init()
    {
        $this->modulesConfig = ArrayHelper::merge($this->getDefaultModulesConfig(), $this->modulesConfig);

        parent::init();
        // инициализация модуля с помощью конфигурации, загруженной из config.php
        \Yii::configure($this, require(__DIR__ . '/config.php'));
        \Yii::$app->setModule('user', [
            'class' => 'rere\user\Module',
            'modelClasses' => [
                'Role' => 'rere\core\models\Role'
            ],
        ]);
    }

    public function getDefaultModulesConfig()
    {
        return [
            'main' => [
                'name' => [
                    'type' => 'text',
                    'tagOptions' => ['class' => 'medium-7 columns'],
                ],
                'created_at' => [
                    'type' => 'date',
                    'tagOptions' => ['class' => 'medium-3 columns'],
                ],
                'status_id' => [
                    'type' => 'checkbox',
                    'tagOptions' => ['class' => 'medium-2 columns'],
                    'label' => 'Активен',
                ],
                'about' => [
                    'type' => 'textArea',
                    'options' => ['rows' => 6],
                ],
            ],
            'data' => [
                'data.content' => [
                    'type' => 'widget',
                    'widget' => '\rere\admin\widgets\TinyMce',
                    'options' => [
                        'options' => ['rows' => 10],
                    ]
                ],
                'data.tags' => [
                    'type' => 'widget',
                    'widget' => '\rere\core\widgets\Tags',
                ],
            ],
            'characters' => [
                'characters' => [
                    'label' => false,
                    'type' => 'widget',
                    'widget' => '\rere\admin\widgets\Characters',
                ],
            ],
            'photos' => [
                'photos' => [
                    'label' => false,
                    'type' => 'widget',
                    'filesLimit' => 1,
//                  'crop' => 1.333333333333,
                    'widget' => '\rere\admin\widgets\PhotoUpload',
                    'options' => [
                        'types' => 'default',
                        'options' => [
//                          'maxFiles' => 1,
                            'maxFilesize' => 4,
                            'acceptedFiles' => 'image/*',
                        ]
                    ],
                ],
            ],
            'seo' => [
                'url' => [
                    'type' => 'text',
                ],
                'data.title' => [
                    'type' => 'text',
                ],
                'data.description' => [
                    'type' => 'textArea',
                    'options' => ['rows' => 2],
                ],
                'data.keywords' => [
                    'type' => 'textArea',
                    'options' => ['rows' => 2],
                ],
            ],
            'position' => [
                'with_child' => [
                    'type' => 'hidden',
                    'value' => 0,
                ],
                'parent_id' => [
                    'type' => 'select',
                    'items' => [null => Yii::t('rere.help', 'Select parent')] + ArrayHelper::map(\rere\core\models\Page::findAll(['with_child' => 1]), 'id', 'name'),
                    'options' => ['rows' => 10],
                ],
                'sort_id' => [
                    'type' => 'number',
                ],
            ],
        ];
    }
}