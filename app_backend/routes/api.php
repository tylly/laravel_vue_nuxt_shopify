<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
  Route::post("/wishlist", [WishlistController::class, 'store'])->name('store');

  Route::get("/wishlist", function () {
    $access_token = env('SHOPIFY_PRIVATE_TOKEN');
    $base_url = env('SHOPIFY_URL');
    $user_id = Auth::id();
    $wishlist_array = Wishlist::where('user_id', $user_id)->get();

    $formatted_ids = $wishlist_array->map(function ($item) {
      return 'id:' . substr($item->product_id, 22);
    })->implode(' OR ');

    $api_version = env("SHOPIFY_API_VERSION");
    $url = "$base_url/admin/api/$api_version/graphql.json";
    $query = "{
  products(first: 10, query: \"$formatted_ids\") {
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
}";

    $payload = json_encode(['query' => $query]);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $payload,
      CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
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
