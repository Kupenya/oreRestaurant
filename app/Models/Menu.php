<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_discounted',
        'category',
    ];

    /**
     * Get the orders associated with this menu item.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}