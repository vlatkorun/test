<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Validators\Orders\CreateValidator;
use App\Http\InputHelpers\Orders\Create;
use App\Http\InputHelpers\Orders\Search;
use App\Repositories\OrdersRepository;
use Auth;

class OrdersController extends Controller
{
    protected $ordersRepository;

    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
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

        $products = $this->ordersRepository->get($params);

        return $this->respondWithCollection($products, $this->ordersRepository->makePresenter(), 'Ok');
    }

    public function show($orderId)
    {
        $order = $this->ordersRepository->find($orderId);

        if(!$order)
        {
            return $this->errorNotFound('Order not found!');
        }

        return $this->respondWithItem($order, $this->ordersRepository->makePresenter(), 'OK');
    }

    public function store(Request $request, Create $inputHelper, CreateValidator $validator)
    {
        $params = $inputHelper->extract($request);

        $validator->setAttributes($params);

        if($validator->fails())
        {
            return $this->errorValidationErrors("Validation errors", $validator->errors()->toArray());
        }

        $params['user_id'] = Auth::user()->id;

        $order = $this->ordersRepository->create($params);

        return $this->respondWithItem($order, $this->ordersRepository->makePresenter(), 'OK');
    }
}