<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "categories";

    protected $guarded = ["id", "created_at", "updated_at"];

    protected $fillable = [
        "name",
        "slug",
        "featured",
        "uuid",
        "parent_category_id"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
        "parent_category_id"
    ];

    protected $casts = [
        "featured" => "boolean",
    ];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, "parent_category_id");
    }
}
