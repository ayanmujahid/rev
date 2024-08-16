<?php

namespace App\Helper;

use Illuminate\Support\Str;
use App\Models\SystemSetting;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class Helper
{
    // Upload Image
    public static function fileUpload($file, $folder, $name): string
    {
        $imageName = Str::slug($name) . '.' . $file->extension();
        $file->move(public_path('uploads/' . $folder), $imageName);
        return 'uploads/' . $folder . '/' . $imageName;
    }

    // Make Slug
    public static function makeSlug($modal, $title): string
    {
        $slug = $modal::where('slug', Str::slug($title))->first();
        if ($slug) {
            $randomString = Str::random(5);
            $slug         = Str::slug($title) . $randomString;
        } else {
            $slug = Str::slug($title);
        }
        return $slug;
    }


    public static function getImage($path)
    {
        $imagePath = $path;
        if (file_exists(public_path($imagePath))) {
            return asset($imagePath); // Return the original image path if it exists
        } else {
            return asset('frontend/images/logo.svg'); // Return a default image path if the original image doesn't exist
        }
    }

    public static function getSetting()
    {
        $setting = SystemSetting::latest('id')->first();
        return $setting;
    }

     public static function getPrintifyProduct()
    {
        $cachedData = Cache::get('printify_products');

        if ($cachedData) {
            $cachedData = json_decode($cachedData);
            return $cachedData;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.printify.com/v1/shops/' . env("PRINTIFY_STORE_ID") . '/products.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . env('PRINTIFY_STORE_TOKEN')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        Cache::put('printify_products', $response, now()->addMinutes(60));

        $response = json_decode($response);
        return $response;
    }

    public static function getShopProducts()
    {
        $products = Product::get();

        return $products;
    }

     public static function fetchPrintify($id)
{
    // Split the ID into product and variant IDs
    $product_id = explode('-', $id);
    $variant_id = $product_id[1] ?? null; // Handle case where $product_id[1] might not exist
    $product_id = $product_id[0] ?? null; // Handle case where $product_id[0] might not exist

    // Get Printify products data
    $printifyProducts = Helper::getPrintifyProduct();

    // Check if the Printify products data is available and has the 'data' property
    if ($printifyProducts === null || !isset($printifyProducts->data)) {
        return []; // Return an empty array if no data is available
    }

    $data = $printifyProducts->data;
    $body = [];

    // Search for the product in the Printify products data
    foreach ($data as $val) {
        if (isset($val->id) && $val->id == $product_id) {
            if (isset($val->variants[0]) && $val->variants[0]->is_available == true && $val->variants[0]->id == $variant_id) {
                $body['title'] = $val->variants[0]->title ?? '';
                $body['description'] = $val->description ?? '';
                $body['image'] = $val->images[0]->src ?? '';
                $body['price'] = $val->variants[0]->price ?? 0;
                $body['quantity'] = $val->variants[0]->quantity ?? 0;
                return $body;
            }
        }
    }

    return []; // Return an empty array if no matching product is found
}

    public static function fetchShop($id)
    {
        $product = Product::where("id", $id)->first();
        if ($product) {
            $body['id'] = $product->id;
            $body['title'] = $product->title;
            $body['description'] = $product->description;
            $body['image'] = Helper::getImage($product->image);
            $body['discount_price'] = $product->discount_price;
            $body['quantity'] = 100;
            return $body;
        } else {
            return [];
        }
    }

    public static function randomStrings($limt)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $randomStrings = [];

        for ($i = 0; $i < $limt; $i++) {
            $randomString = '';
            for ($j = 0; $j < $limt; $j++) {
                $randomString .= $characters[random_int(0, strlen($characters) - 1)];
            }
            $randomStrings[] = $randomString;
        }

        return $randomStrings;
    }
}
