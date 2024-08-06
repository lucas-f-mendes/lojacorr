<?php

namespace App\Enum;

class UsersEnum
{
    const USER_TEST = 1;

    static $names = array(
        self::USER_TEST => "Usuário LojaCorr"
    );

    public static function getUsers()
    {
        return self::$names;
    }
}
