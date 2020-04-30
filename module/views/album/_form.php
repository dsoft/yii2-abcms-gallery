<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GalleryAlbum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-album-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'categoryId')->dropDownList($model::returnCategoriesList()); ?>
    
    <?= $form->field($model, 'images[]')->fileInput(['multiple' => true])->label('Add Images'); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'ordering')->textInput() ?>
    
    <?= \abcms\multilanguage\widgets\TranslationForm::widget(['model' => $model, 'form' => $form]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
