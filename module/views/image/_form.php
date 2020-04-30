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
    
    <?= $structure ? \abcms\structure\widgets\Form::widget(['model' => $model, 'form' => $form, 'structure' => $structure]) : null ?>
    
    <?= $structureTranslation ? \abcms\multilanguage\widgets\TranslationForm::widget(['model' => $structureTranslation, 'form' => $form]) : null ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
