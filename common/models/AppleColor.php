<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "apple_color".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 */
class AppleColor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple_color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'color'], 'required'],
            [['name', 'slug', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'color' => Yii::t('app', 'Color'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AppleColorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppleColorQuery(get_called_class());
    }

    public static function listAll()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}
