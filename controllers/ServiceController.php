<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 18.05.2015
 * Time: 18:49
 */

namespace rere\admin\controllers;


use rere\core\defaultModels\PageCounts;
use rere\core\models\Page;
use Yii;

class ServiceController extends Controller
{
    public function actionCountStat()
    {
        $count = 0;
        /** @var Page $row */
        foreach (Page::findAll(['with_child' => 0]) as $row) {
            $data = new PageCounts();
            $new = $data::findOne(['page_id' => $row->id]);
            if ($new) $data = $new;
            /** @var $data PageCounts */
            $data->setAttributes([
                'page_id' => $row->id,
                'views' => $row->getViewsCount(),
                'likes' => $row->getLikesCount(),
                'comments' => $row->getCommentsCount(),
            ], false);
            if ($data->save(false)) $count++;
        }
        print $count;
    }

}