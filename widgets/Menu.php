<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 10.04.2015
 * Time: 10:14
 */

namespace rere\admin\widgets;


class Menu extends \yii\widgets\Menu
{
    public $data = [];

    public function run()
    {
        /** @var \rere\core\models\Page $row */
        if (count($this->data)) foreach ($this->data as $row)
            $this->items[] = [
                'label' => $row->getLabel(),
                'url' => $row->getHref(),
                'active' => $row->getActive()
            ];

        parent::run();
    }

}