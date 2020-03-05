<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Apples');
$this->params['breadcrumbs'][] = $this->title;

\backend\assets\AppleAsset::register($this);
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Generate Apples'), ['generate'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin([
        'id' => 'apples-wrapper'
    ]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'color_id',
                'format' => 'html',
                'value' => function(\common\models\Apple $model) {
                    $color = $model->color->color;
                    return "<i class='fa fa-fw fa-apple' style='color: $color; font-size: 80px'></i>";
                }
            ],
            [
                'attribute' => 'state',
                'value' => function(\common\models\Apple $model) {
                    return $model->stateLabel;
                }
            ],
            [
                'attribute' => 'size',
                'format' => 'html',
                'value' => function(\common\models\Apple $model) {
                    $size = $model->size * 100;

                    $html = "<div class='c100 p$size small green'>
                      <span>$size%</span>
                      <div class='slice'>
                        <div class='bar'></div>
                        <div class='fill'></div>
                      </div>
                    </div>";

                    return $html;
                }
            ],
            'created_at:datetime',
            'fallen_at:datetime',

//            ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {fall} {eat}',
                'buttons' => [
                    'fall' => function ($url, \common\models\Apple $model) {
                        $url = \yii\helpers\Url::to(['fall', 'id' => $model->id]);
                        $disabled = $model->isOnTree() ? '' : ' disabled';
                        return Html::a(
                            Yii::t('app', 'fall'),
                            $url,
                            [
                                'class' => 'btn btn-primary fall-btn' . $disabled,
                                'data-pjax' => '0',
                            ]
                        );
                    },
                    'eat' => function ($url, \common\models\Apple $model) {
                        $url = \yii\helpers\Url::to(['eat', 'id' => $model->id]);
                        $disabled = $model->isFallen() ? '' : ' disabled';
                        return Html::a(
                            Yii::t('app', 'eat'),
                            $url,
                            [
                                'class' => 'btn btn-success eat-btn' . $disabled,
                                'data-pjax' => '0',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<div class="modal fade" id="eatModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eat percent</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
