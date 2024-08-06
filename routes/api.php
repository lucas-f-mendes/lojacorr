<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post("authentication/login", "login")->name("api.auth.login");
    });

    Route::middleware("auth")->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::prefix("authentication")->group(function () {
                Route::get("logout", "logout")->name("api.auth.logout");
                Route::get("me", "me")->name("api.auth.me");
                Route::get("validate", "validateToken")->name("api.auth.validate");
            });
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get("categories", "index")->name("api.category.index");
            Route::get("categories/{id}", "show")->name("api.category.show");
            Route::post("categories", "create")->name("api.category.create");
            Route::delete("categories/{id}", "destroy")->name("api.category.destroy");
            Route::match(["patch", "put"], "categories/{id}", "update")->name("api.category.update");
        });

        Route::prefix("categories/{cat_id}")->group(function () {
            Route::controller(SubcategoryController::class)->group(function () {
                Route::post("subcategories", "create")->name("api.subcategory.create");
                Route::delete("subcategories/{id}", "destroy")->name("api.subcategory.destroy");
                Route::match(["patch", "put"], "subcategories/{id}", "update")->name("api.subcategory.update");
            });
        });
    });
});
