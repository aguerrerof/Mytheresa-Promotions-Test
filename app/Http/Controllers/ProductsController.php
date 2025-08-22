<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProductsRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{

    public function index(IndexProductsRequest $request): JsonResponse
    {
        $query = Product::query();
        if ($request->filled('category')) {
            $query->where('category', $request->getCategory());
        }
        if ($request->filled('price_less_than')) {
            $query->where('price', '<=', $request->getPriceLessThan());
        }
        $lengthAwarePaginator = $query->paginate($request->getPerPage());
        return response()->json([
            'products' => ProductResource::collection($lengthAwarePaginator)->resolve(),
            'total' => $lengthAwarePaginator->total(),
            'per_page' => $lengthAwarePaginator->perPage(),
            'current_page' => $lengthAwarePaginator->currentPage(),
            'last_page' => $lengthAwarePaginator->lastPage(),
        ]);
    }
}
