<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 28.05.2015
 * Time: 16:09
 */

namespace rere\admin\controllers;


use Yii;
use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        parent::init();
        if (Yii::$app->user->isGuest)
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function render($view, $params = [])
    {
        $type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        return parent::$type($view, $params);
    }


}