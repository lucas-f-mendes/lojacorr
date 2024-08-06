<?php

namespace Database\Seeders;

use App\Enum\UsersEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = UsersEnum::getUsers();

        foreach ($users as $user) {
            DB::table("users")->insert([
                "name" => ucfirst($user),
                "alias" => Str::slug($user, "."),
                "email" => Str::slug($user, ".") . "@lojacorr.com.br",
                "password" => Hash::make("lojacorr"),
                "created_at" => new \DateTime()
            ]);
        }
    }
}
