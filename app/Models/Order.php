<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'order_time',
    ];

    protected $casts = [
        'order_time' => 'datetime',
    ];

    /**
     * Define the relationship between Order and User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the many-to-many relationship with Menu.
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'order_menu')->withPivot('quantity');
    }

    /**
     * Calculate the total price based on the items in the order.
     */
    public function calculateTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->menus as $menu) {
            $totalPrice += $menu->price * $menu->pivot->quantity;
        }
        $this->total_price = $totalPrice;
        $this->save();
    }
}