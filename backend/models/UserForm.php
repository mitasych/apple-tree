<?php
namespace backend\models;

use Yii;
use common\models\User;
use yii\base\Model;

class UserForm extends Model
{
    private $user;

    public $username;
    public $email;
    public $status;
    public $password;

    public function __construct(User $user = null, $config = [])
    {
        if ($user) {
            $this->user = $user;

            $this->username = $user->username;
            $this->email = $user->email;
            $this->status = $user->status;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['username', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                if ($this->user) {
                    $query->andWhere(['not', ['id' => $this->user->id]]);
                }
            }],
            ['password', 'required', 'on' => 'create'],
            [['username'], 'string', 'min' => 2, 'max' => 255],
            [['password'], 'string', 'min' => 4],
            [['email'], 'email'],
            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['status', 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Returns User Statuses Collection
     * @return array
     */
    public static function statuses(): array
    {
        return User::statuses();
    }
}