<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 09.04.2015
 * Time: 14:18
 */

namespace rere\admin\widgets;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\widgets\Menu;

class FormGenerator extends \yii\base\Widget
{

    /**
     * @var $form \yii\widgets\ActiveForm
     */
    public $form;
    public $model;
    public $config;

    /**
     * @return string
     */
    public function run()
    {
        $result = '';

        $items = [];
        foreach (array_keys($this->config) as $val)
            $items[] = [
                'label' => \Yii::t('rere.admin', $val),
                'url' => '#' . strtolower($val),
                'active' => empty($items)
            ];

        $result .= Menu::widget([
            'items' => $items,
            'itemOptions' => [
                'class' => 'tab-title',
            ],
            'options' => [
                'class' => 'tabs',
                'data-tab' => true,
            ]
        ]);

        $classList = [];
        $result .= Html::beginTag('div', ['class' => 'tabs-content row']);
        foreach ($this->config as $tab => $value) {
            $result .= Html::beginTag('div', ['class' => 'content' . (current($this->config) == $value ? ' active' : ''), 'id' => strtolower($tab)]);
            foreach ($value as $name => $settings) {
                $type = strtolower($settings['type']);
                $options = isset($settings['options']) ? $settings['options'] : [];
                if (!$type) continue;

                /** @var \yii\db\ActiveRecord $model */
                $model = $this->model;
                $attributes = explode('.', $name);
                foreach ($attributes as $attribute) if ($attribute)
                    if ($attribute != end($attributes)) {
                        if ($model->{$attribute})
                            $model = $model->{$attribute};
                        else {
                            $data = $model->getRelation($attribute);
                            $model = new $data->modelClass;
                        }
                    } elseif ($data = $model->getRelation($attribute, false)) {
                        /** @var ActiveRecord $temp */
                        $temp = new $data->modelClass;
                        $classList[$temp->formName()] = $data->modelClass;
                    }
                if (empty($attribute)) continue;
                if ($model->isNewRecord && Yii::$app->request->isPost) $model->load(Yii::$app->request->post());
                $classList[$model->formName()] = $model::className();

                if (isset($settings['value'])) {
                    $model->$attribute = $settings['value'];
                    unset($settings['value']);
                }

                $field = $this->form->field($model, $attribute);
                if (empty($settings['tagOptions']['class'])) $settings['tagOptions']['class'] = 'column';
                $field->options = $settings['tagOptions'];
                if (isset($settings['label'])) $field->label($settings['label']);
                if ($type == 'date') $model->{$attribute} = Yii::$app->formatter->asDatetime($model->{$attribute}, 'yyyy-MM-dd');
                if ($type == 'hidden') $field->label('');
                if ($type == 'widget')
                    $result .= $field->widget($settings['widget'], $options);
                elseif ($type == 'select')
                    $result .= $field->dropDownList($settings['items'], $options);
                elseif (stripos($type, 'list'))
                    $result .= $field->$type($settings['items'], $options);
                elseif (method_exists($field, $type))
                    $result .= $field->{$type}($options);
                else {
                    $result .= $field->input($type, $options);
                }
            }
            $result .= Html::tag('div', '', ['class' => 'clearfix']);
            $result .= Html::endTag('div');
        }
        $result .= Html::endTag('div');

        $result .= Html::hiddenInput('modelsList', serialize($classList));

        return $result;
    }

}