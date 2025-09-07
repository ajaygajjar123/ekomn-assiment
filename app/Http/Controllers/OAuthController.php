<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OAuthController extends Controller
{
    public function install(Request $request)
    {
        $shop = $request->query('shop');
        abort_if(!$shop, 400, 'Missing shop domain.');

        $query = http_build_query([
            'client_id'    => env('SHOPIFY_API_KEY'),
            'scope'        => env('SHOPIFY_SCOPES'),
            'redirect_uri' => env('SHOPIFY_REDIRECT_URI'),
        ]);

        return redirect()->away("https://{$shop}/admin/oauth/authorize?{$query}");
    }

    public function callback(Request $request)
    {
        $shop = $request->query('shop');
        $hmac = $request->query('hmac');
        $code = $request->query('code');
        abort_if(!$shop || !$hmac || !$code, 400, 'Invalid callback params.');

        // --- HMAC check ---
        $params = $request->query();
        unset($params['hmac'], $params['signature']);
        ksort($params);
        $data = urldecode(http_build_query($params));
        $calc = hash_hmac('sha256', $data, env('SHOPIFY_API_SECRET'));
        abort_if(!hash_equals($hmac, $calc), 403, 'HMAC verification failed.');

        $resp = Http::post("https://{$shop}/admin/oauth/access_token", [
            'client_id'     => env('SHOPIFY_API_KEY'),
            'client_secret' => env('SHOPIFY_API_SECRET'),
            'code'          => $code,
        ]);

        abort_unless($resp->ok(), 500, 'Token exchange failed.');
        $token = $resp->json('access_token');

        Shop::updateOrCreate(
            ['shop_domain' => $shop],
            ['access_token' => $token]
        );
        return redirect()->route('app.home', ['shop' => $shop]);
    }
}
