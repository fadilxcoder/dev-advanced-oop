<?php

namespace Codebase\Services;

use Codebase\Managers\DbManager;

class UserManagementService
{
    public function encryptUserPassword(String $password) {
        $encryptPassword = hash('sha512', $password);
        
        return $encryptPassword;
    }

    public function getUserByUsernameAndPassword(String $username, String $password) {
        $encryptPassword = $this->encryptUserPassword($password);
        $user = DbManager::getInstance()->select('user', '*', [
                'username'  => $username,
                'password'  => $encryptPassword,
                "LIMIT"     => [0, 1]
            ]
        );
        
        return ($user && null !== $user && count($user) === 1) ? $user[0] : null;
    }

    public function getGroupByUser(int $userId){
        $groups = DbManager::getInstance()->select('user_group', '*', [
                'id_user'  => $userId
            ]
        );

        return $groups;
    }

    public function isUserInGroup(int $userId, int $groupId){
        $groups = DbManager::getInstance()->select('user_group', '*', [
                'id_user'  => $userId,
                'id_group' => $groupId
            ]
        );

        return count($groups) > 0;
    }

    public function updateLastLogin(int $userId){
        $update = DbManager::getInstance()->update('user',
            [
                'last_login' => (new \DateTime("now"))->format("Y-m-d H:i:s")
            ],
            [
                'id_user' => $userId
            ]
        );
        
        return $update->rowCount() === 1;
    }
}