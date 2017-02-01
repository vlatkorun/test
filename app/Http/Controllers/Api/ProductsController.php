<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\InputHelpers\Products\Search;
use App\Repositories\ProductsRepository;

class ProductsController extends Controller
{
    protected $productRepository;

    public function __construct(ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request, Search $inputHelper)
    {
        $orderBy = $request->has('orderBy') ? $request->get('orderBy') : 'created_at';
        $orderDirection = $request->has('orderDirection') ? $request->get('orderDirection') : 'desc';

        $params = [
            'page' => $request->has('page') ? $request->get('page') : 0,
            'limit' => $request->has('limit') && is_int((int) $request->get('limit'))? (int) $request->get('limit') : 0,
            'search' => $inputHelper->extract($request),
            'ordering' => [$orderBy => $orderDirection],
        ];

        $products = $this->productRepository->get($params);

        return $this->respondWithCollection($products, $this->productRepository->makePresenter(), 'Ok');
    }

    public function show($productId)
    {
        $product = $this->productRepository->find($productId);

        if(!$product)
        {
            return $this->errorNotFound('Product not found!');
        }

        return $this->respondWithItem($product, $this->productRepository->makePresenter(), 'OK');
    }
}