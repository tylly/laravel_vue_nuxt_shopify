<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/api/test', function () {
    return response()->json(['message' => 'Laravel and Nuxt are connected!']);
});

Route::get('/api/get-products', function () {
    $access_token = env('SHOPIFY_PRIVATE_TOKEN');
    $base_url = env('SHOPIFY_URL');
    $api_version = env("SHOPIFY_API_VERSION");
    $url = "$base_url/admin/api/$api_version/graphql.json";
    $query = '{
  products(first: 3) {
    edges {
      node {
        id
        title
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

require __DIR__ . '/settings.php';
