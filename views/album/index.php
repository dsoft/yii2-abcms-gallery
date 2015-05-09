<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\modules\gallery\models\GalleryAlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gallery Albums';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-album-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gallery Album', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            [
                'attribute' => 'categoryId',
                'value' => function($data) {
            return $data->returnCategoryName();
        },
            ],
            'ordering',
            ['class' => 'abcms\grid\ActivateColumn'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
