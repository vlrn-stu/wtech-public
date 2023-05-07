<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\CartItem;
use App\Models\Shipping;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    private function calculateTotalAmount()
    {
        $totalAmount = 0;
        $cartItems = $this->getCartItems();

        foreach ($cartItems as $cartItem) {
            $item = Item::find($cartItem->item_id);
            $totalAmount += $item->price * $cartItem->quantity;
        }

        return $totalAmount;
    }

    private function getCartItems()
    {
        $cartItems = null;

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;
            $cartItems = $cart->cartItems;
        } else {
            $cartItemsSession = Session::get('cartItems', []);
            $cartItems = collect(array_map(function ($cartItem) {
                $item = Item::find($cartItem['item_id']);
                if ($item != null) {
                    return new CartItem([
                        'item_id' => $item->id,
                        'quantity' => $cartItem['quantity'],
                    ]);
                }
                return null;
            }, $cartItemsSession));
            $cartItems = $cartItems->filter(function ($cartItem) {
                return $cartItem != null;
            });
        }

        $cartItems = $cartItems->filter(function ($cartItem) {
            $item = Item::find($cartItem->item_id);
            if ($item !== null) {
                if ($item->stock->quantity == 0) {
                    return false;
                } else if ($item->stock->quantity < $cartItem->quantity) {
                    $cartItem->quantity = $item->stock->quantity;
                }
                return true;
            }
            return false;
        })->values();


        return $cartItems;
    }

    private function getShipping()
    {
        $shipping = null;

        if (Auth::check()) {
            $user = Auth::user();
            $shipping = $user->shipping;
        } else if (session()->has('shipping_id')) {
            $shipping = Shipping::find(session('shipping_id'));
        }

        return $shipping;
    }

    private function getPayment()
    {
        $payment = null;

        if (session()->has('payment_id')) {
            $payment = Payment::find(session('payment_id'));
        }

        return $payment;
    }

    private function createOrder()
    {
        $userId = Auth::id();
        $shipping = $this->getShipping();
        $payment = $this->getPayment();
        $cartItems = $this->getCartItems();

        if ($shipping == null || $payment == null || $cartItems == null) {
            return false;
        }

        $order = Order::create([
            'user_id' => $userId,
            'shipping_id' => $shipping->id,
            'payment_id' => $payment->id,
        ]);

        foreach ($cartItems as $cartItem) {
            $item = Item::find($cartItem->item_id);
            if ($item == null || $item->stock->quantity < $cartItem->quantity) {
                continue;
            } else {
                $order->orderItems()->create([
                    'order_id' => $order->id,
                    'item_id' => $cartItem->item_id,
                    'quantity' => $cartItem->quantity,
                ]);
                $stock = $item->stock;
                $stock->quantity -= $cartItem->quantity;
                $stock->save();
            }
        }

        $this->clearCart();

        return true;
    }

    private function clearCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;
            $cart->cartItems()->delete();
        } else {
            Session::forget('cartItems');
        }

        Session::forget('payment_id');
    }

    public function index()
    {
        $cartItems = $this->getCartItems();

        return view('cart.index', ['cartItems' => $cartItems]);
    }

    public function addItem(Request $request)
    {
        $item_id = $request->input('item_id');
        $quantity = $request->input('quantity', 1);

        if ($quantity < 1) {
            return response()->json(['error' => 'Quantity must be greater than 0'], 400);
        }

        $item = Item::find($item_id);
        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;

            $cartItem = CartItem::where([
                'cart_id' => $cart->id,
                'item_id' => $item->id,
            ])->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $quantity;
                if ($item->stock->quantity < $newQuantity) {
                    return response()->json(['error' => 'Not enough stock'], 400);
                }
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            } else {
                if ($item->stock->quantity < $quantity) {
                    return response()->json(['error' => 'Not enough stock'], 400);
                }
                CartItem::create([
                    'cart_id' => $cart->id,
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            $cartItems = Session::get('cartItems', []);
            $itemKey = array_search($item_id, array_column($cartItems, 'item_id'));

            if ($itemKey !== false) {
                $newQuantity = $cartItems[$itemKey]['quantity'] + $quantity;
                if ($item->stock->quantity < $newQuantity) {
                    return response()->json(['error' => 'Not enough stock'], 400);
                }
                $cartItems[$itemKey]['quantity'] = $newQuantity;
            } else {
                if ($item->stock->quantity < $quantity) {
                    return response()->json(['error' => 'Not enough stock'], 400);
                }
                $cartItem = [
                    'item_id' => $item->id,
                    'quantity' => $quantity
                ];
                array_push($cartItems, $cartItem);
            }

            Session::put('cartItems', $cartItems);
        }

        return response()->json(['success' => 'Item added to cart'], 200);
    }

    public function updateItem(Request $request, $item_id)
    {
        $quantity = $request->input('quantity');
        $item = Item::find($item_id);

        if ($item->stock->quantity < $quantity) {
            return response()->json(['error' => 'Not enough stock'], 400);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;

            $cartItem = CartItem::where('cart_id', $cart->id)->where('item_id', $item_id)->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            } else {
                return response()->json(['error' => 'Item not found'], 404);
            }
        } else {
            $cartItems = Session::get('cartItems', []);
            $itemKey = array_search($item_id, array_column($cartItems, 'item_id'));

            if ($itemKey !== false) {
                $cartItems[$itemKey]['quantity'] = $quantity;
                Session::put('cartItems', $cartItems);
            } else {
                return response()->json(['error' => 'Item not found'], 404);
            }
        }

        return response()->json(['success' => true]);
    }

    public function removeItem(Request $request, $item_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;

            $cartItem = CartItem::where('cart_id', $cart->id)->where('item_id', $item_id)->first();
            if ($cartItem) {
                $cartItem->delete();
            } else {
                return response()->json(['error' => 'Item not found'], 404);
            }
        } else {
            $cartItems = Session::get('cartItems', []);
            $itemKey = array_search($item_id, array_column($cartItems, 'item_id'));

            if ($itemKey !== false) {
                unset($cartItems[$itemKey]);
                $cartItems = array_values($cartItems);
                Session::put('cartItems', $cartItems);
            } else {
                return response()->json(['error' => 'Item not found'], 404);
            }
        }

        return response()->json(['success' => true]);
    }

    public function shipping()
    {
        if ($this->getCartItems() == null) {
            return redirect()->route('cart.index');
        }

        $shipping = $this->getShipping();

        return view('cart.shipping', ['shipping' => $shipping]);
    }

    public function storeShipping(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'post_code' => 'required|string|max:255',
            'street_name' => 'required|string|max:255',
            'street_number' => 'required|string|max:255',
        ]);

        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::id();
        }

        $shipping = Shipping::create([
            'user_id' => $user_id,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'country' => $validatedData['country'],
            'city' => $validatedData['city'],
            'post_code' => $validatedData['post_code'],
            'street_name' => $validatedData['street_name'],
            'street_number' => $validatedData['street_number'],
        ]);

        session(['shipping_id' => $shipping->id]);

        return redirect()->route('cart.payment');
    }

    public function payment()
    {
        if (!(session()->has('shipping_id'))) {
            return redirect()->route('cart.index');
        }

        $paymentMethod = 1;

        $payment = $this->getPayment();

        if ($payment != null) {
            $paymentMethod = $payment->type;
        }

        return view('cart.payment', ['paymentMethod' => $paymentMethod]);
    }

    public function storePayment(Request $request)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|integer',
        ]);

        $totalAmount = $this->calculateTotalAmount();
        $payment = $this->getPayment();

        if ($payment != null) {
            $payment->type = $validatedData['payment_method'];
            $payment->amount = $totalAmount;
            $payment->save();
        } else {
            $payment = Payment::create([
                'type' => $validatedData['payment_method'],
                'amount' => $totalAmount,
                'payed' => false,
                'payed_at' => null
            ]);

            session(['payment_id' => $payment->id]);
        }

        return redirect()->route('cart.overview');
    }

    public function overview()
    {
        $shipping = $this->getShipping();
        $payment = $this->getPayment();
        $cartItems = $this->getCartItems();
        $totalAmount = $this->calculateTotalAmount();

        if ($shipping == null || $payment == null || $cartItems == null) {
            // These must never be null at this point, only way they could be is if the user navigates to this page without going through the previous steps
            return redirect()->route('cart.index');
        }

        return view('cart.overview', [
            'shipping' => $shipping,
            'paymentMethod' => $payment->type,
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function storeOverview(Request $request)
    {
        if ($this->createOrder()) {
            return redirect()->route('cart.success');
        } else {
            return redirect()->route('cart.index');
        }
    }

    public function success()
    {
        return view('cart.success');
    }
}
