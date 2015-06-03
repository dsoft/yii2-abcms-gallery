<?php

namespace abcms\galleryModule\controllers;

use Yii;
use abcms\galleryModule\models\GalleryAlbum;
use abcms\galleryModule\models\GalleryAlbumSearch;
use abcms\library\base\CrudController;
use yii\web\NotFoundHttpException;
use abcms\galleryModule\models\GalleryImageSearch;

/**
 * AlbumController implements the CRUD actions for GalleryAlbum model.
 */
class AlbumController extends CrudController
{

    /**
     * Lists all GalleryAlbum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GalleryAlbumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GalleryAlbum model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $searchModel = new GalleryImageSearch();
        $searchModel->albumId = $model->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new GalleryAlbum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GalleryAlbum();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->saveImages();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GalleryAlbum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->saveImages();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GalleryAlbum model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the GalleryAlbum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GalleryAlbum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GalleryAlbum::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
