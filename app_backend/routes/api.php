<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post("/wishlist", [WishlistController::class, 'store'])->name('store');
});

Route::get('/get-products', function () {
    $access_token = env('SHOPIFY_PRIVATE_TOKEN');
    $base_url = env('SHOPIFY_URL');
    $api_version = env("SHOPIFY_API_VERSION");
    $url = "$base_url/admin/api/$api_version/graphql.json";
    $query = '{
  products(first: 10) {
    edges {
      node {
        id
        title
        priceRangeV2 {
          minVariantPrice{
            amount
          }
          maxVariantPrice{
            amount
          }
        }
        featuredMedia {
          preview {
            image {
              url
            }
          }
        }
      }
    }
  }
}';

    $payload = json_encode(['query' => $query]);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            // 'Accept: application/json',
            "X-Shopify-Access-Token: $access_token",
        ],
        CURLOPT_RETURNTRANSFER => true
    ]);

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        return response()->json(['error' => $curlError], 500);
    }
    return response()->json(json_decode($response));
});
