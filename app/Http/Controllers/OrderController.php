<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Retrieve all orders for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
{
    $orders = Order::with('menus')->get();

    $orders->transform(function ($order) {
        $order->menu_items = $order->menus->map(function ($menu) {
            return [
                'menu_name' => $menu->name,
                'quantity' => $menu->pivot->quantity,
                'price' => $menu->price
            ];
        });
        return $order;
    });

    return response()->json($orders);
}



    /**
     * Retrieve a specific order for the authenticated user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
{
    $order = Order::with('menus')->findOrFail($id);

    $order->menu_items = $order->menus->map(function ($menu) {
        return [
            'menu_name' => $menu->name,
            'quantity' => $menu->pivot->quantity,
            'price' => $menu->price
        ];
    });

    return response()->json($order);
}

    /**
     * Create a new order for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Order::class); // Check if the user has permission to create an order

        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate the total price
        $totalPrice = $this->calculateTotalPrice($request->items);

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'order_time' => now(),
        ]);

        // Attach items to the order in the pivot table
        foreach ($request->items as $item) {
            $order->menus()->attach($item['menu_id'], ['quantity' => $item['quantity']]);
        }

        return response()->json($order, 201); // Return the created order
    }

    /**
     * Calculate the total price of the order.
     *
     * @param  array  $items
     * @return float
     */
    protected function calculateTotalPrice(array $items): float
    {
        $totalPrice = 0;
        foreach ($items as $item) {
            $menu = Menu::find($item['menu_id']);
            if ($menu) {
                $totalPrice += $menu->price * $item['quantity'];
            } else {
                throw new \Exception("Menu item with ID {$item['menu_id']} not found.");
            }
        }
        return $totalPrice;
    }

    public function updateStatus(Request $request, $id)
{
    // Validate the incoming request
    $request->validate([
        'status' => 'required|string|in:pending,completed,cancelled',
    ]);

    // Find the order by ID
    $order = Order::findOrFail($id);

    // Update the status of the order
    $order->status = $request->input('status');
    $order->save();

    return response()->json(['message' => 'Order status updated successfully', 'order' => $order]);
}

}