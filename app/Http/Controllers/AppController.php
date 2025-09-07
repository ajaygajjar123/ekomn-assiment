<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppController extends Controller
{
    public function index(Request $request)
    {
        $shopDomain = $request->shop;
        $shop = $shopDomain ? Shop::where('shop_domain', $shopDomain)->first() : null;
        if (!$shop) {
            return redirect()->route('install', ['shop' => $shopDomain]);
        }
        $token = $shop->access_token;
        $version = env('SHOPIFY_API_VERSION', '2023-07');
        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $token,
        ])->get("https://{$shop->shop_domain}/admin/api/{$version}/products.json");
        $products = $response->json()['products'] ?? [];

        return view('app', ['shopDomain' => $shop->shop_domain,'products'=> $products]);
    }
}
