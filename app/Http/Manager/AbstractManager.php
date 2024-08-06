<?php

namespace App\Http\Manager;

use App\Http\Interface\ContractInterface;
use Illuminate\Support\Facades\DB;

abstract class AbstractManager implements ContractInterface
{
    protected function getInstanceBuilder($table)
    {
        return DB::table($table);
    }

    protected function getInstanceModel($model)
    {
        $model = ucwords($model);
        $model = "\App\Models\\{$model}";

        return new $model;
    }

    protected function getServices($service)
    {
        $service = ucwords($service);
        $service = "\App\Http\Services\\{$service}Service";

        return new $service;
    }

    protected function getRepository($repository)
    {
        $repository = ucwords($repository);
        $repository = "\App\Http\Repository\\{$repository}Repository";

        return new $repository;
    }
}
