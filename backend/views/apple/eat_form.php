<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \backend\models\EatForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'percent')->textInput()->hint(Yii::t('app', 'Enter a number from 1 to ' . $model->size)) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Eat'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
