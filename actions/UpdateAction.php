<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 16.07.2015
 * Time: 16:24
 */

namespace rere\admin\actions;


use Yii;
use yii\base\Action;

class UpdateAction extends Action
{
    public function run()
    {
        $path = Yii::getAlias('@app');
        $command = "cd $path;php-cli composer.phar self-update;php-cli composer.phar update";
//        $command = "composer {$path} update";
//        exec(, $data, $return);
//        print_r($data);
//        return $return;

        $output = shell_exec($command);
        return "<pre>$command\n$output</pre>";
    }

}