<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AppleColor */

$this->title = Yii::t('app', 'Create Apple Color');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apple Colors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-color-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
