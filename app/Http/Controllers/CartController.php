<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $id,
                'pname' => $product->pname,
                'pimage' => $product->images,
                'ptitle' => $product->ptitle,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::where('user_id', auth()->id())->where('product_id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function update(Request $request, $productId)
    {
        $action = $request->input('action');
        $cartItem = Cart::where('product_id', $productId)->first();

        if ($cartItem) {
            if ($action === 'increment') {
                $cartItem->quantity++;
            } elseif ($action === 'decrement' && $cartItem->quantity > 1) {
                $cartItem->quantity--;
            }
            $cartItem->save();
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }

}
