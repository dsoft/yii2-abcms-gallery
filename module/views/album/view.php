<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\GalleryAlbum */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Gallery Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-album-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'categoryId',
                'value' => $model->returnCategoryName(),
            ],
            'active',
            'ordering',
        ],
    ])
    ?>
    
    <?= \abcms\multilanguage\widgets\TranslationView::widget([
        'model' => $model,
    ]) ?>


    <h2>Images</h2>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'image',
                'value' => function($data) {
            return $data->returnImageLink();
        },
                'format' => ['image', ['width' => 200]],
            ],
            'ordering',
            [
                'class' => abcms\library\grid\ActivateColumn::className(),
                'controller' => 'image',
            ],
            [
                'class' => yii\grid\ActionColumn::className(),
                'controller' => 'image',
                'template' => '{update} {delete}',
            ],
        ],
    ]);
    ?>

</div>
