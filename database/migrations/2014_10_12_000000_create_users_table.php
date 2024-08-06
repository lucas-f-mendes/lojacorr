<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("users", function (Blueprint $table) {
            $table->increments("id");
            $table->string("name", 255);
            $table->string("alias", 100);
            $table->string("phone", 13)->nullable();
            $table->string("email")->unique()->nullable();
            $table->string("password")->nullable();
            $table->boolean("status")->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("users");
    }
};
