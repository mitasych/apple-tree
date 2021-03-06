<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/avatar04.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => Yii::t('app', 'Apple Tree menu'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('app', 'Apples'), 'icon' => 'apple', 'url' => ['/apple']],
                    ['label' => Yii::t('app', 'Apple Colors'), 'icon' => 'paint-brush', 'url' => ['/apple-color']],
                    ['label' => Yii::t('app', 'Admin menu'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('app', 'Users'), 'icon' => 'list', 'url' => ['/user']],
                    [
                        'label' => 'Gii',
                        'icon' => 'file-code-o',
                        'url' => ['/gii'],
                        'visible' => YII_ENV == 'dev'
                    ],
                    [
                        'label' => 'Debug',
                        'icon' => 'dashboard',
                        'url' => ['/debug'],
                        'visible' => YII_DEBUG === true
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
