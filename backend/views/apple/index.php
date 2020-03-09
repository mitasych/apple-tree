<?php

use kartik\date\DatePicker;
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'color_id',
                'filter' => \common\models\AppleColor::listAll(),
                'format' => 'html',
                'value' => function(\common\models\Apple $model) {
                    $color = $model->color->color;
                    return "<i class='fa fa-fw fa-apple' style='color: $color; font-size: 60px'></i>";
                }
            ],
            [
                'attribute' => 'state',
                'filter' => \common\models\Apple::states(),
                'format' => 'html',
                'value' => function(\common\models\Apple $model) {
                    $state = $model->state;
                    switch ($state) {
                        case \common\models\Apple::STATE_ON_TREE :
                            return "<span class='label label-warning'>$model->stateLabel</span>";
                            break;
                        case \common\models\Apple::STATE_FELL :
                            return "<span class='label label-success'>$model->stateLabel</span>";
                            break;
                        case \common\models\Apple::STATE_ROTTEN :
                            return "<span class='label label-danger'>$model->stateLabel</span>";
                            break;
                        default :
                            return $model->stateLabel;
                            break;
                    }
                }
            ],
            [
                'attribute' => 'percent',
                'format' => 'html',
                'label' => Yii::t('app', 'Percent'),
                'value' => function(\common\models\Apple $model) {
                    $size = $model->size * 100;

                    return "<div class='c100 p$size mini green'>
                      <span>$size%</span>
                      <div class='slice'>
                        <div class='bar'></div>
                        <div class='fill'></div>
                      </div>
                    </div>";
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'create_date_start',
                    'attribute2' => 'create_date_end',
                    'type' => DatePicker::TYPE_RANGE,
                    'layout' => '<span class="input-group-addon kv-field-separator">' . Yii::t('app', 'from') . '</span>{input1}{separator}{input2}',
                    'language' => 'ru',
                    'separator' => Yii::t('app', 'to'),
                    'convertFormat' => true,
                    'options' => [
                        'autocomplete' => 'off'
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'orientation' => 'bottom',
                        'clearBtn' => true
                    ],
                ]),
                'value' => function(\common\models\Apple $model) {
                    return $model->created_at;
                }
            ],
            [
                'attribute' => 'fallen_at',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'fallen_date_start',
                    'attribute2' => 'fallen_date_end',
                    'type' => DatePicker::TYPE_RANGE,
                    'layout' => '<span class="input-group-addon kv-field-separator">' . Yii::t('app', 'from') . '</span>{input1}{separator}{input2}',
                    'language' => 'ru',
                    'separator' => Yii::t('app', 'to'),
//                     'convertFormat' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'orientation' => 'bottom',
                        'clearBtn' => true
                    ],
                ]),
                'value' => function(\common\models\Apple $model) {
                    return $model->fallen_at;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{fall} {eat}',
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                <h4 class="modal-title"><?php echo Yii::t('app', 'Eat percent') ?></h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
