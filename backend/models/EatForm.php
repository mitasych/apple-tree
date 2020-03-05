<?php

namespace backend\models;

use common\models\Apple;
use yii\base\Model;

class EatForm extends Model
{
    private $apple;

    public $percent;
    public $size;

    /**
     * EatForm constructor.
     * @param Apple $apple
     * @param array $config
     */
    public function __construct(Apple $apple, $config = [])
    {
        $this->apple = $apple;
        $this->size = $this->apple->size * 100;

        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['percent', 'integer', 'min' => 1, 'max' => $this->size]
        ];
    }

    /**
     * @return Apple
     */
    public function getApple(): Apple
    {
        return $this->apple;
    }


}