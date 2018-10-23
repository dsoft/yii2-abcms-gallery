<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GalleryImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($album, 'images[]')->fileInput()->label('Image'); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'ordering')->textInput() ?>
    
    <?= \abcms\structure\widgets\Form::widget(['model' => $model, 'structure' => ['name' => null, 'modelId' => $model->returnModelId(), 'pk' => null]]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
