<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("products", function (Blueprint $table) {
            $table->increments("id");
            $table->integer("category_id")->unsigned();
            $table->string("name", 150);
            $table->string("slug", 200);
            $table->boolean("featured")->default(false);
            $table->integer("stock")->nullable()->default(0);
            $table->decimal("price", 7, 2)->nullable()->default(0);
            $table->integer("height")->nullable();
            $table->integer("width")->nullable();
            $table->integer("weight")->nullable();
            $table->longtext("description")->nullable();
            $table->string("uuid", 36);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("category_id", "FK_PRODUCT_CATEGORY")
                ->references("id")
                ->on("categories")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::table("products", function ($table) {
            $table->dropForeign("FK_PRODUCT_CATEGORY");
        });

        Schema::dropIfExists("products");
    }
};
