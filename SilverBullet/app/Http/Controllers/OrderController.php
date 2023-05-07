<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function markAsShipped($id)
    {
        $order = Order::findOrFail($id);
        $shipping = $order->shipping;
        $shipping->shipped = true;
        $shipping->shipped_at = now();
        $shipping->save();

        // Return a response or redirect based on your needs
        return response()->json(['success' => true, 'message' => 'Order marked as shipped']);
    }

    public function markAsPaid($id)
    {
        $order = Order::findOrFail($id);
        $payment = $order->payment;
        $payment->payed = true;
        $payment->payed_at = now();
        $payment->save();

        // Return a response or redirect based on your needs
        return response()->json(['success' => true, 'message' => 'Order marked as paid']);
    }
}
