<?php

namespace abcms\gallery\module\controllers;

use Yii;
use abcms\gallery\module\models\GalleryImage;
use abcms\library\base\CrudController;
use yii\web\NotFoundHttpException;

/**
 * ImageController implements the CRUD actions for GalleryImage model.
 */
class ImageController extends CrudController
{

    /**
     * Updates an existing GalleryImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $album = $model->album;

        if($model->load(Yii::$app->request->post()) && $model->save()) {
            $album->saveImages($model);
            return $this->redirect(['album/view', 'id' => $album->id]);
        }
        else {
            return $this->render('update', [
                        'model' => $model,
                        'album' => $album,
            ]);
        }
    }

    /**
     * Deletes an existing GalleryImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $album = $model->album;
        $model->delete();

        return $this->redirect(['album/view', 'id' => $album->id]);
    }

    /**
     * Activate/Deactivate an existing model.
     * If action is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $album = $model->album;
        $model->activate()->save(false);

        return $this->redirect(['album/view', 'id' => $album->id]);
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
