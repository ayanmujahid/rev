<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\View\View;
use DB;
use Helper;

class ShopController extends Controller {
    /**
     * Fetches all active ProductCategories and Products.
     * Returns the shop view with this data.
     *
     * @return View
     */
     public function shop(Request $request, $id = null) {
    $categories = ProductCategory::where('status', 'active')->get();
    $search_query = $request->input('search');
    $selected_category = $id ?? $request->input('category');

    // Initialize the query for local products
    $productsQuery = Product::where('status', 'active');

    if ($search_query) {
        $productsQuery->where('title', 'like', '%' . $search_query . '%');
    }

    if ($selected_category) {
        $productsQuery->where('category_id', $selected_category);
    }

    $products = $productsQuery->get();

    // Apply search query to latest products as well
    $latestProductsQuery = Product::where('status', 'active')->latest()->take(6);

    if ($search_query) {
        $latestProductsQuery->where('title', 'like', '%' . $search_query . '%');
    }

    if ($selected_category) {
        $latestProductsQuery->where('category_id', $selected_category);
    }

    $latest_product = $latestProductsQuery->get();

    // Recommended products
    $recommended_products = Cart::select(
        'product_id',
        DB::raw('COUNT(*) as count'),
        DB::raw('
            CASE
                WHEN image_path LIKE "%printify%" THEN "Printify"
                ELSE "Shop"
            END as type
        ')
    )
    ->groupBy('product_id', 'type')
    ->orderBy('count', 'desc')
    ->get()->toArray();

    // Fetch and search Printify products
    $printifyProducts = Helper::getPrintifyProduct();
    $printifyResults = [];
    if ($printifyProducts && $search_query) {
        foreach ($printifyProducts->data as $printData) {
            if (stripos($printData->title, $search_query) !== false || stripos($printData->description, $search_query) !== false) {
                $printifyResults[] = $printData;
            }
        }
    }

    // Combine local and Printify results (optional: separate into different collections if needed)
    $combinedResults = [
        'local' => $products,
        'printify' => $printifyResults
    ];

    return view('frontend.layout.shop', compact('categories', 'products', 'latest_product', 'recommended_products', 'search_query', 'selected_category', 'combinedResults'));
}





}