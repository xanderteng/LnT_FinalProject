<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

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

}
