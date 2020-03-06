<?php
namespace console\services;

use common\models\Apple;

class AppleConsoleService
{
    /**
     * @var \common\repositories\AppleRepository
     */
    private $apples;

    /**
     * AppleConsoleService constructor.
     * @param \common\repositories\AppleRepository $apples
     */
    public function __construct(\common\repositories\AppleRepository $apples)
    {
        $this->apples = $apples;
    }

    /**
     * Promotes rotting apples
     */
    public function rotApples(): void
    {
        $appleModels = Apple::find()->toRot()->all();

        foreach ($appleModels as $apple) {
            try {
                $apple->rot();
                $apple->save();
            } catch (\Exception $e) {
                \Yii::error($e->getMessage(), 'rotting');
                continue;
            }
        }
    }
}