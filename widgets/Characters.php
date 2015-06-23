<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 09.04.2015
 * Time: 16:03
 */

namespace rere\admin\widgets;


use rere\core\models\Character;
use rere\core\models\PageCharacters;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class Characters extends InputWidget
{

    /**
     * @return string
     */
    public function run()
    {
        $result = '';

        $characters = [];
        foreach ($this->model->characters as $character)
            $characters[$character->name] = $character;

        $result .= Html::beginTag('div', ['class' => 'characterList']);

        foreach (Character::find()->all() as $key => $data) {
            $character = isset($characters[$data->url]) ? $characters[$data->url] : new PageCharacters();
            $id = $character->id ? $character->id : $key;

            if ($character->id) $result .= Html::hiddenInput('PageCharacters[' . $id . '][id]', $character->id);
            $result .= Html::hiddenInput('PageCharacters[' . $id . '][value]', '');
            if (empty($character->name)) {
                $character->name = $data->url;
                $result .= Html::hiddenInput('PageCharacters[' . $id . '][name]', $data->url);
            }
            if ($data['type'] == 'checkbox') {
                $result .= Html::checkbox('PageCharacters[' . $id . '][value]', $character->value, ['id' => 'character' . $id]);
                $result .= Html::label($character->name, 'character' . $id);
            } else {
                $result .= Html::label($character->name, 'character' . $id);
                $result .= Html::input($data['type'], 'PageCharacters[' . $id . '][value]', $character->value ? $character->value : null, ['id' => 'character' . $id]);
            }
        }
        $result .= Html::endTag('div');

        $result .= Html::button('добавить характеристику', ['data-reveal-id' => 'addCharacter', 'data-reveal-ajax' => Url::to(['edit/character-add'])]);

        $this->view->registerJs('$(\'body\').append(\'<div id="addCharacter" class="reveal-modal tiny" data-reveal="1"></div>\')');

        return $result;
    }
}