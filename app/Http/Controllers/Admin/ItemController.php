<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return view('admin.items', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'itemName' => 'required|string|min:5|max:80',
            'itemCategory' => 'required|exists:categories,id',
            'itemPrice' => 'required|integer|min:100',
            'itemQuantity' => 'required|integer|min:0',
            'itemPicture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $now = now()->format('Y-m-d_H.i.s');
        $itemPictureFile = $request->file('itemPicture');
        $itemPictureFilename = $now . '_' . $itemPictureFile->getClientOriginalName();
        $itemPictureFile->storeAs('itemPicture', $itemPictureFilename, 'public');

        Item::create([
            'itemName' => $request->itemName,
            'category_id' => $request->itemCategory,
            'itemPrice' => $request->itemPrice,
            'itemQuantity' => $request->itemQuantity,
            'itemPicture' => $itemPictureFilename,
        ]);

        return redirect()->route('admin.items')->with('success', 'Item created successfully!');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();

        return view('admin.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'itemName' => 'required|string|max:80',
            'itemCategory' => 'required|exists:categories,id',
            'itemPrice' => 'required|integer|min:1',
            'itemQuantity' => 'required|integer|min:0',
            'itemPicture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Picture optional for update
        ]);

        $item = Item::findOrFail($id);

        if ($request->hasFile('itemPicture')) {
            $now = now()->format('Y-m-d_H.i.s');
            $itemPictureFile = $request->file('itemPicture');
            $itemPictureFilename = $now . '_' . $itemPictureFile->getClientOriginalName();
            $itemPictureFile->storeAs('itemPicture', $itemPictureFilename, 'public');
            $item->itemPicture = $itemPictureFilename;
        }

        $item->update([
            'itemName' => $request->itemName,
            'category_id' => $request->itemCategory,
            'itemPrice' => $request->itemPrice,
            'itemQuantity' => $request->itemQuantity,
        ]);

        return redirect()->route('admin.items')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        if ($item->itemPicture && Storage::disk('public')->exists('itemPicture/' . $item->itemPicture)) {
            Storage::disk('public')->delete('itemPicture/' . $item->itemPicture);
        }
        $item->delete();

        return redirect()->route('admin.items')->with('success', 'Item deleted successfully!');
    }

    public function viewInvoices()
    {
        $invoices = Invoice::with('user')->get();  
        return view('admin.viewinvoices', compact('invoices'));
    }
    
}
