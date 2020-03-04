<?php


namespace common\repositories;


use common\models\Apple;
use http\Exception\RuntimeException;

class AppleRepository
{
    public function get(int $id): Apple
    {
        if (!$apple = Apple::find()->where(['id' => $id])->one()) {
            throw new \DomainException('Apple not found.');
        }

        return $apple;
    }

    public function save(Apple $apple): void
    {
        if (!$apple->save()) {
            throw new RuntimeException('Saving error.');
        }
    }
}