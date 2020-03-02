<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => \common\models\User::statuses(),
                'format' => 'html',
                'value' => function(\common\models\User $model) {
                    $status = $model->status;
                    switch ($status) {
                        case \common\models\User::STATUS_ACTIVE :
                            return "<span class='label label-success'>$model->statusLabel</span>";
                        break;
                        case \common\models\User::STATUS_INACTIVE :
                            return "<span class='label label-warning'>$model->statusLabel</span>";
                        break;
                        case \common\models\User::STATUS_DELETED :
                            return "<span class='label label-danger'>$model->statusLabel</span>";
                        break;
                        default :
                            return $model->statusLabel;
                        break;
                    }
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => false
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'filter' => false
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
