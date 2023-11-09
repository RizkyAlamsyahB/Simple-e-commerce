<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        return view('cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $quantity = (int)$request->quantity;
        if ($quantity > 0) {
            \Cart::add([
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $quantity, // Gunakan quantity yang telah divalidasi
                'attributes' => [
                    'image' => $request->image,
                ]
            ]);

            session()->flash('success', 'Product is Added to Cart Successfully!');
            return redirect()->route('cart.list');
        } else {
            // Tampilkan pesan kesalahan karena quantity tidak valid
            session()->flash('error', 'Invalid quantity. Please provide a positive number.');
            return redirect()->back();
        }
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );
        session()->flash('success', 'Item Cart is Updated Successfully !');
        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');
        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();
        session()->flash('success', 'All Item Cart Clear Successfully !');
        return redirect()->route('cart.list');
    }
}
