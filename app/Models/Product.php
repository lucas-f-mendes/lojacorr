<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        "name",
        "slug",
        "featured",
        "stock",
        "price",
        "height",
        "width",
        "weight",
        "description",
        "uuid",
        "category_id",
    ];

    protected $hidden = [
        "category_id",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    protected $casts = [
        "featured" => "boolean",
        "price" => "float"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
