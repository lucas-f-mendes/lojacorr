<?php

namespace App\Http\Interface;

interface ContractInterface
{
    public function create($object);

    public function update($object, $id);

    public function get($id);

    public function fetch($limit, $sortBy);

    public function remove($id);
}
