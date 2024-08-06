<?php

namespace App\Http\Manager;

use Illuminate\Support\Facades\Hash;

class UserManager extends AbstractManager
{
    protected function getManager()
    {
        return $this->getInstanceModel("user");
    }

    public function create($request)
    {
        //
    }

    public function update($request, $id)
    {
        //
    }

    public function remove($id)
    {
        //
    }

    public function get($id)
    {
        //
    }

    public function fetch($limit = 10, $sort_by = array())
    {
        //
    }
}
