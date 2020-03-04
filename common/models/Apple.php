<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%apple}}".
 *
 * @property int $id
 * @property int $color_id
 * @property int $state
 * @property float $size
 * @property int $created_at
 * @property int|null $fallen_at
 * @property int $active
 *
 * @property string $stateLabel
 *
 * @property AppleColor $color
 */
class Apple extends \yii\db\ActiveRecord
{
    const STATE_ON_TREE = 10;
    const STATE_FELL = 20;
    const STATE_ROTTEN = 30;

    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

    /**
     * Creates Apple object
     * @param integer $color_id
     * @return self
     */
    public static function create(int $color_id): self
    {
        $apple = new self();
        $apple->color_id = $color_id;
        $apple->state = self::STATE_ON_TREE;
        $apple->size = 1;
        $apple->created_at = time();
        $apple->active = self::STATUS_ACTIVE;

        return $apple;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apple}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_id', 'state', 'size'], 'required'],
            [['color_id', 'state', 'fallen_at', 'active'], 'integer'],
            [['size'], 'number'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppleColor::class, 'targetAttribute' => ['color_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'color_id' => Yii::t('app', 'Color'),
            'state' => Yii::t('app', 'State'),
            'size' => Yii::t('app', 'Size'),
            'created_at' => Yii::t('app', 'Created At'),
            'fallen_at' => Yii::t('app', 'Fallen At'),
        ];
    }

    /**
     * Sets activity to Deleted
     * @return void
     */
    public function remove(): void
    {
        $this->active = self::STATUS_DELETED;
    }

    /**
     * Sets state to Fell
     * @return void
     */
    public function fallToGround(): void
    {
        $this->state = self::STATE_FELL;
    }

    /**
     * Sets state to Eaten
     * @param integer $percent
     * @return void
     */
    public function eat(int $percent): void
    {
        $this->size =- $percent / 100;

        if ($this->size < 0) {
            $this->size = 0;
        }

        if ($this->size == 0) {
            $this->remove();
        }
    }

    /**
     * Sets state to Rotten
     * @return void
     */
    public function rot(): void
    {
        $this->state = self::STATE_ROTTEN;
    }


    /**
     * Gets query for [[AppleColor]].
     *
     * @return \yii\db\ActiveQuery|AppleColorQuery
     */
    public function getColor()
    {
        return $this->hasOne(AppleColor::className(), ['id' => 'color_id']);
    }

    /**
     * @return string
     */
    public function getStateLabel(): string
    {
        $states = self::states();

        return $states[$this->state];
    }

    /**
     * {@inheritdoc}
     * @return AppleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppleQuery(get_called_class());
    }

    /**
     * Returns states collection
     * @return array
     */
    public static function states(): array
    {
        return [
            self::STATE_ON_TREE => Yii::t('app', 'hanging on a tree'),
            self::STATE_FELL => Yii::t('app', 'lies on the ground'),
            self::STATE_ROTTEN => Yii::t('app', 'rotten')
        ];
    }
}
