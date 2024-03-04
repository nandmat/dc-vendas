<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{


    public function getProduct($productId)
    {
        $product = Product::find($productId);

        try {

            if (!is_null($product)) {

                return response()
                    ->json([
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price
                    ]);
            }

            return response()
                ->json(['error' => 'Não foi possível realizar esta ação!'], 401);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()
                ->json(['error' => 'Não foi possível realizar esta ação!'], 500);
        }
    }
}
