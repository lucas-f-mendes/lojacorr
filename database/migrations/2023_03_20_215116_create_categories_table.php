<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("categories", function (Blueprint $table) {
            $table->increments("id");
            $table->integer("parent_category_id")->unsigned()->nullable();
            $table->string("name", 200);
            $table->string("slug", 150);
            $table->boolean("featured")->default(false);
            $table->string("uuid", 36);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("parent_category_id", "FK_CATEGORY")
                ->references("id")
                ->on("categories")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::table("categories", function ($table) {
            $table->dropForeign("FK_CATEGORY");
        });

        Schema::dropIfExists("categories");
    }
};
