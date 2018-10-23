<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GalleryImage */

$this->title = 'Update Gallery Image: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gallery Albums', 'url' => ['album/index']];
$this->params['breadcrumbs'][] = ['label' => $album->title, 'url' => ['album/view', 'id' => $model->albumId]];
$this->params['breadcrumbs'][] = 'Update Image';
?>
<div class="gallery-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'album'=>$album,
    ]) ?>

</div>
