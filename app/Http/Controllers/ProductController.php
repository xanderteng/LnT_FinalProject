<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');  
        $selectedCategories = $request->input('category');  

        $categories = Category::all();
        $query = Item::with('category');

        if ($search) {
            $query->where('itemName', 'like', '%' . $search . '%');
        }

        if ($selectedCategories) {
            $query->whereIn('category_id', $selectedCategories);
        }

        $items = $query->get();

        return view('products', compact('categories', 'items'));
    }

    public function addToCart(Request $request)
    {
        $item = Item::findOrFail($request->item_id); 
        $cart = Session::get('cart', []);

        if (isset($cart[$item->id])) {
            $cart[$item->id]['quantity'] += $request->quantity;
        } else {
            $cart[$item->id] = [
                'itemName' => $item->itemName,
                'itemPicture' => $item->itemPicture,
                'itemPrice' => $item->itemPrice,
                'quantity' => $request->quantity,
                'itemQuantity' => $item->itemQuantity
            ];
        }

        Session::put('cart', $cart);  

        return redirect()->route('cart')->with('success', 'Item added to cart!');
    }

    public function cart()
    {
        if (!Auth::check()) {
            return redirect()->route('getLogin')->with('message', 'You must be logged in to access your cart.');
        }
    
        $cartItems = Session::get('cart', []);
    
        $totalPrice = collect($cartItems)->sum(function ($item) {
            return $item['itemPrice'] * $item['quantity'];
        });
    
        return view('cart', compact('cartItems', 'totalPrice'));
    }
    

    public function updateAddress(Request $request)
    {
        $request->validate([
            'home_address' => 'required|string|min:5|max:80',
            'postal_code' => [
                'required',
                'regex:/^\d{5}$/',  
            ],
        ], [
            'home_address.required' => 'Home address is required.',
            'home_address.min' => 'Home address must be at least 5 characters.',
            'home_address.max' => 'Home address must not exceed 80 characters.',
            
            'postal_code.required' => 'Postal code is required.',
            'postal_code.regex' => 'Postal code must be exactly 5 digits.',
        ]);

        Session::put('home_address', $request->home_address);
        Session::put('postal_code', $request->postal_code);

        return redirect()->route('cart')->with('success', 'Address updated successfully!');
    }

    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->item_id])) {
            $change = (int)$request->input('quantity_change', 0);
            $cart[$request->item_id]['quantity'] += $change;

            if ($cart[$request->item_id]['quantity'] < 1) {
                $cart[$request->item_id]['quantity'] = 1;
            } elseif ($cart[$request->item_id]['quantity'] > $cart[$request->item_id]['itemQuantity']) {
                $cart[$request->item_id]['quantity'] = $cart[$request->item_id]['itemQuantity'];
            }

            Session::put('cart', $cart);
        }

        return redirect()->route('cart');
    }

    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);
        $itemId = $request->input('item_id');

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Item removed from cart!');
    }

    public function confirmOrder(Request $request)
    {
        $request->validate([
            'home_address' => 'required|string|min:5|max:80',
            'postal_code' => ['required', 'regex:/^\d{5}$/'],
        ], [
            'home_address.required' => 'Delivery address is required.',
            'postal_code.required' => 'Postal code is required.',
            'postal_code.regex' => 'Postal code must be exactly 5 digits.',
        ]);

        $cartItems = Session::get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $totalPrice = collect($cartItems)->sum(function ($item) {
            return $item['itemPrice'] * $item['quantity'];
        });

        $invoiceId = (string)Str::uuid();

        DB::table('invoices')->insert([
            'id' => $invoiceId,
            'user_id' => Auth::id(),  
            'home_address' => $request->home_address,
            'postal_code' => $request->postal_code,
            'items' => json_encode($cartItems),
            'total_price' => $totalPrice,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Clear cart after order confirmation
        Session::forget('cart');

        return redirect()->route('invoice.show', ['id' => $invoiceId])->with('success', 'Order confirmed! Invoice generated.');
    }


}
