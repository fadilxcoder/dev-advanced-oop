<?php

namespace Codebase\Fixtures;

use Codebase\Managers\DbManager;
use Codebase\Services\UserManagementService;
use Ramsey\Uuid\Uuid;

class DataFixtures
{
    public function init()
    {
        $userMgmt = new UserManagementService();

        DbManager::getInstance()->drop("group");
        DbManager::getInstance()->drop("user");
        DbManager::getInstance()->drop("user_group");

        // CREATE DATABASE
        echo " > CREATE 'group' DATABASE\n\r";

        DbManager::getInstance()
            ->create("group", [
                "id_group" => [
                    "INT",
                    "NOT NULL",
                    "AUTO_INCREMENT",
                    "PRIMARY KEY"
                ],
                "name" => [
                    "VARCHAR(100)",
                    "DEFAULT NULL"
                ]
            ]);

        echo " > CREATE 'user'  DATABASE\n\r";

        DbManager::getInstance()
            ->create("user", [
                "id_user" => [
                    "INT",
                    "NOT NULL",
                    "AUTO_INCREMENT",
                    "PRIMARY KEY"
                ],
                "uuid" => [
                    "VARCHAR(255)",
                    "NOT NULL"
                ],
                "username" => [
                    "VARCHAR(45)",
                    "DEFAULT NULL"
                ],
                "password" => [
                    "VARCHAR(255)",
                    "DEFAULT NULL"
                ],
                "last_login" => [
                    "datetime",
                    "DEFAULT NULL"
                ]
            ]);

        echo " > CREATE 'user_group'  DATABASE\n\r";

        DbManager::getInstance()
            ->create("user_group", [
                "id_user" => [
                    "INT",
                    "NOT NULL"
                ],
                "id_group" => [
                    "INT",
                    "NOT NULL"
                ]
            ]);

        echo " > -----------------------------------------------------------------\n\r";

        // INSERT DATAS
        echo " > INSERT 'groups' \n\r";

        DbManager::getInstance()
            ->insert("group", [
                [
                    "id_group" => 1,
                    "name" => "Groupe 1"
                ],
                [
                    "id_group" => 2,
                    "name" => "Groupe 2"
                ],
                [
                    "id_group" => 3,
                    "name" => "Groupe 3"
                ]
            ]);


        echo " > INSERT 'users' \n\r";

        DbManager::getInstance()
            ->insert("user", [
                [
                    "id_user" => 1,
                    "uuid" => Uuid::uuid4()->toString(),
                    "username" => "fadilxcoder",
                    "password" => $userMgmt->encryptUserPassword("admin"),
                    "last_login" => "2011-09-28 12:00:00"
                ],
                [
                    "id_user" => 2,
                    "uuid" => Uuid::uuid4()->toString(),
                    "username" => "bocasay",
                    "password" => $userMgmt->encryptUserPassword("bocasay"),
                    "last_login" => "2011-09-28 12:00:00"
                ],
                [
                    "id_user" => 3,
                    "uuid" => Uuid::uuid4()->toString(),
                    "username" => "johndoe",
                    "password" => $userMgmt->encryptUserPassword("admin"),
                    "last_login" => "2011-09-28 12:00:00"
                ],
            ]);


        echo " > INSERT 'user_group' \n\r";

        DbManager::getInstance()
            ->insert("user_group", [
                [
                    "id_user" => 1,
                    "id_group" => 2
                ],
                [
                    "id_user" => 2,
                    "id_group" => 1
                ],
                [
                    "id_user" => 2,
                    "id_group" => 3
                ]
            ]);

        echo " > -----------------------------------------------------------------\n\r";
    }
}