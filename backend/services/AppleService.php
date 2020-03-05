<?php


namespace backend\services;


use backend\models\EatForm;
use common\models\Apple;
use common\models\AppleColor;
use common\repositories\AppleRepository;

class AppleService
{
    /**
     * @var AppleRepository
     */
    private $apples;

    /**
     * AppleService constructor.
     * @param AppleRepository $apples
     */
    public function __construct(AppleRepository $apples)
    {
        $this->apples = $apples;
    }

    /**
     * Deactivates Apple model
     * @param integer $id
     * @return void
     */
    public function removeApple(int $id): void
    {
        $apple = $this->apples->get($id);

        $apple->remove();

        $this->apples->save($apple);
    }

    /**
     * @param integer|null $count
     */
    public function generateApples(int $count = null): void
    {
        $count = !$count ? rand(5, 20) : $count;

        $colors = AppleColor::find()->select('id')->column();

        for ($i = 1; $i <= $count; $i++) {
            $colorIndex = array_rand($colors);

            $this->createApple((int)$colors[$colorIndex]);
        }
    }

    /**
     * @param integer $color_id
     */
    public function createApple(int $color_id): void
    {
        $apple = Apple::create($color_id);

        $this->apples->save($apple);
    }

    /**
     * @param $id
     */
    public function fallApple($id): void
    {
        $apple = $this->apples->get($id);

        $apple->fallToGround();

        $this->apples->save($apple);
    }

    /**
     * @param EatForm $form
     */
    public function eatApple(EatForm $form): void
    {
        $apple = $form->getApple();

        $apple->eat($form->percent);

        $this->apples->save($apple);
    }
}