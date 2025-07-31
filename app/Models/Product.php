<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
