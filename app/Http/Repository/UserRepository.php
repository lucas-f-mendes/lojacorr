<?php

namespace App\Http\Repository;

use App\Http\Manager\UserManager;

class UserRepository extends UserManager
{
    public function getUserByTypeAccess($key, $value)
    {
        return $this->getManager()
            ->where($key, $value)
            ->first();
    }
}
