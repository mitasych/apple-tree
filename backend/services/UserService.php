<?php


namespace backend\services;


use backend\models\UserForm;
use common\models\User;

class UserService
{
    private $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     * @param UserForm $form
     * @return User
     * @throws \DomainException
     */
    public function createUser(UserForm $form): User
    {
        $user = new User();
        $user = $this->baseFieldsValues($user, $form);
        $user->setPassword($form->password);
        $user->generateAuthKey();

        if (!$user->save()) {
            throw new \DomainException('Can not save user');
        }

        return $user;
    }

    public function updateUser(int $id, UserForm $form): User
    {
        $user = User::findOne($id);

        if (!$user) {
            throw new \DomainException('User not found.');
        }

        $user = $this->baseFieldsValues($user, $form);

        if ($form->password) {
            $user->setPassword($form->password);
        }

        if (!$user->save()) {
            throw new \DomainException('Can not save user');
        }

        return $user;
    }

    /**
     * Assigns values to basic properties
     * @param User $user
     * @param UserForm $form
     * @return User
     */
    private function baseFieldsValues(User $user, UserForm $form)
    {
        $user->username = $form->username;
        $user->email = $form->email;
        $user->status = $form->status;

        return $user;
    }
}