<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderCreateRequest;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = Order::with('items.product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

            if ($orders->isEmpty()) {
                return response()->json(['message' => 'No orders found'], 404);
            }

        return OrderResource::collection($orders);
    }

    public function getUser($id)
    {
        $orders = Order::with('items.product')
            ->where('user_id', $id)
            ->latest()
            ->get();
        
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found for this user'], 404);
        }

        return OrderResource::collection($orders);
    }

    public function store(OrderCreateRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try{
            $totalPrice = 0;

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    return response()->json([
                        'message' => 'Insufficient stock for product: ' . $product->name], 400);
                }

                $subtotal = $product->price * $item['quantity'];
                $totalPrice += $subtotal;

                $product->stock -= $item['quantity'];
                $product->save();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);

            DB::commit();

            return new OrderResource($order->load('items.product'));

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json(['message' => 'Order creation failed: ' . $e->getMessage()], 500);
        }
    }
}
