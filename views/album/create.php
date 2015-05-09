<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GalleryAlbum */

$this->title = 'Create Gallery Album';
$this->params['breadcrumbs'][] = ['label' => 'Gallery Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-album-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
