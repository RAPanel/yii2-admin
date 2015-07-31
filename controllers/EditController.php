<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 23.03.2015
 * Time: 18:43
 */

namespace rere\admin\controllers;

use rere\core\models\Character;
use rere\core\models\Module;
use rere\core\models\ModuleSettings;
use rere\core\models\Page;
use rere\core\models\Photo;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class EditController extends Controller
{
    public function actionIndex($id = null, $parent = null, $module_id = null, $back = null)
    {
        if ($id)
            $base = Page::findOne($id);
        elseif ($parent) {
            $base = new Page();
            $base->setAttribute('parent_id', $parent);
            if (Yii::$app->request->isPost) $base->save(false);
        } else {
            $this->redirect(['structure/index']);
        }
        if (empty($base))
            throw new HttpException(404, 'Can`t find page');
        if ($module_id)
            Yii::$app->session->set('editModule', $base->module_id = $module_id);
        elseif (empty($base->module_id))
            $base->module_id = Yii::$app->session->get('editModule', 10);

        $selectList = [];
        foreach (Module::all() as $key => $val)
            $selectList[$key] = Yii::t('admin.module', $val);

        $defaultConfig = $this->module->modulesConfig;

        $settings = ModuleSettings::get($base->module_id);

        foreach($settings as $key => $value){
            if(isset($defaultConfig[$key]) && !$value){
                unset($defaultConfig[$key]);
            }
            if($value){
                if($key == 'photos' && $value){
                    $defaultConfig['photos']['photos']['filesLimit'] = $value;
                }
                if(empty($defaultConfig[$key])){
                    if($key == 'photosTypes' && $value){
                        $defaultConfig['photos']['photos']['options']['types'] = $value;
                    }
                }
            }
        }

        $config = $defaultConfig;

        if (($request = Yii::$app->request) && $request->isPost) {
            $models = [];
            foreach (unserialize($request->post('modelsList')) as $name => $class) {
                $data = $name == $base->formName() ? $base : new $class;

                $model = true;
                if (null !== $request->post($name)) {
                    foreach ($request->post($name) as $key => $value)
                        if (is_numeric($key)) {
                            $model = false;
                            if (!empty($value['id'])) $models[$name . $key] = $data::findOne($value['id']);
                            else $models[$name . $key] = clone $data;
                            $models[$name . $key]->attributes = $value;
                        }
                    if ($model) {
                        if (!$data->hasAttribute('page_id') || !($models[$name] = $data::findOne(['page_id' => $base->id])))
                            $models[$name] = $data;
                        $models[$name]->attributes = $request->post($name);
                    }
                }
            }

            $errors = [];
            /** @var ActiveRecord $value */
            foreach ($models as $key => $value) {
                if ($value->hasAttribute('page_id') && empty($value->page_id))
                    $value->page_id = $base->id;
                if ($value->hasAttribute('owner_id') && empty($value->owner_id))
                    $value->owner_id = $base->id;
                if (!$value->validate())
                    $errors = ArrayHelper::merge($errors, $value->errors);
            }
            $save = true;
            if (empty($errors)) foreach ($models as $key => $value) {
                /** @var ActiveRecord $value */
                $save = $value->save(false) && $save;
            } else $save = false;
            if ($save) {
                $this->redirect($back ? $back : ['structure/index', 'id' => $id ? $id : $parent]);
            }

            ActiveRecord::validateMultiple($models);
        }

        return $this->render($this->action->id, compact('base', 'data', 'config'));
    }

    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($file = UploadedFile::getInstanceByName('file')) {
            $temp = uniqid() . '.' . pathinfo($file->name, PATHINFO_EXTENSION);
            list($w, $h) = getimagesize($file->tempName);
            if (FileHelper::createDirectory($dir = Yii::getAlias('@webroot/image/tmp/')))
                Image::thumbnail($file->tempName, 400, round($h / $w * 400))->save($dir . $temp, ['quality' => 80]);
            $dir = Yii::getAlias('@runtime/uploadedFiles/');
            if (Yii::$app->session->id) $dir .= Yii::$app->session->id . '/';
            if (FileHelper::createDirectory($dir))
                return [
                    'success' => $file->saveAs($dir . $file->name),
                    'tmp' => Photo::$path . '/' . $temp,
                    'tmpName' => $temp,
                    'data' => $file,
                ];
        }

        return new HttpException(404);
    }

    public function actionPhotoDelete($id = null)
    {
        return $id ? Photo::findOne($id)->delete() : $id;
    }

    public function actionCharacterAdd()
    {
        $model = new Character();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            /** @var \yii\db\Query $query */
            $query = $model::find()->where(['url' => $model->url]);
            if ($query->exists()) $model = $query->one();
            else {
                $model->save();
            }
            return $model->field();
        }

        return $this->render($this->action->id, compact('model'));
    }
}