<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.07.2015
 * Time: 16:24
 */

namespace rere\admin\actions;


use rere\core\widgets\fileManager\FileManager;
use Yii;
use yii\base\Action;

class FileManagerAction extends Action
{
    public function run()
    {
        return FileManager::widget();
    }

}