<?php

namespace abcms\gallery\module\controllers;

use Yii;
use abcms\gallery\module\models\GalleryImage;
use abcms\library\base\AdminController;
use yii\web\NotFoundHttpException;
use abcms\structure\models\Structure;

/**
 * ImageController implements the CRUD actions for GalleryImage model.
 */
class ImageController extends AdminController
{

    /**
     * Updates an existing GalleryImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $returnUrl = null)
    {
        $model = $this->findModel($id);
        $album = $model->album;
        
        $structure = Structure::findOne(['modelId' => $model->returnModelId(), 'pk' => null]);
        $structureTranslation = $structure ? $structure->getStructureTranslation($model) : null;
        $model->enableAutoStructuresSaving($structure, $structureTranslation);

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            $album->saveImages($model);
            if(!$returnUrl){
                $returnUrl = ['album/view', 'id' => $album->id];
            }
            return $this->redirect($returnUrl);
        }
        else {
            return $this->render('update', [
                        'model' => $model,
                        'album' => $album,
                        'structure' => $structure,
                        'structureTranslation' => $structureTranslation,
            ]);
        }
    }

    /**
     * Deletes an existing GalleryImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $returnUrl = null)
    {
        $model = $this->findModel($id);
        $album = $model->album;
        $model->delete();
        if(!$returnUrl){
            $returnUrl = ['album/view', 'id' => $album->id];
        }

        return $this->redirect($returnUrl);
    }

    /**
     * Activate/Deactivate an existing model.
     * If action is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id, $returnUrl = null)
    {
        $model = $this->findModel($id);
        $album = $model->album;
        $model->activate()->save(false);
        if(!$returnUrl){
            $returnUrl = ['album/view', 'id' => $album->id];
        }
        
        return $this->redirect($returnUrl);
    }

    /**
     * Finds the GalleryImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GalleryImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = GalleryImage::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
