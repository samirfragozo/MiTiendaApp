<?php

namespace App\Http\Controllers\Storekeeper;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreRequest;
use App\Store;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StoreController extends BaseController
{
    /**
     * Create a controller instance.
     *
     * @param Store $entity
     */
    public function __construct(Store $entity)
    {
        parent::__construct($entity);

        $this->crud = 'storekeeper.stores';
        $this->images = 'stores';
        $this->middleware(function ($request, $next) {
            $request->request->add(['user_id' => auth()->id()]);
            $this->model = $this->entity::where('user_id', auth()->id())->store()->orderBy('name');

            return $next($request);
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return parent::storeBase($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, int $id)
    {
        return parent::updateBase($request, $id);
    }

    // Custom

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function orders(Request $request)
    {
        $store = Store::where([['id', $request->store], ['user_id', auth()->id()]])->store()->first();

        if ( is_null($store) ) return abort(404);

        if ($request->ajax()) return Datatables::of($store->orders()->with('user')->orderBy('created_at', 'desc'))->make(true);

        return view('app.index')->with([
            'crud' => 'storekeeper.orders',
            'title' => __('app.titles.storekeeper.stores'),
            'subtitle' => __('app.titles.storekeeper.orders') . ' - ' . $store->full_name,
            'tools' => [
                'create' => false,
                'reload' => true,
            ],
            'table' => [
                'check' => false,
                'fields' => ['created_at', 'user_id', 'quantity', 'total', 'status'],
                'active' => false,
                'actions' => true,
            ],
            'form' => [],
        ]);
    }

    /**
     * Display a listing of the products for the order.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function orderProducts(Request $request)
    {
        $store = Store::where([['id', $request->store], ['user_id', auth()->id()]])->store()->first();

        if ( is_null($store) ) return abort(404);

        $order = \App\Order::where([['id', $request->order], ['store_id', $store->id]])->store()->first();

        if ( is_null($order) ) return abort(404);

        if ($request->ajax()) return Datatables::of($order->products()->orderBy('name'))->make(true);

        return view('app.index')->with([
            'crud' => 'order_product',
            'title' => __('app.titles.storekeeper.stores'),
            'subtitle' =>
                __('validation.attributes.date') . ': ' . $order->created_at . ' // ' . __('validation.attributes.total') . ': $' .  $order->total . ' // ' . __('validation.attributes.user_id') . ': ' . $order->user->full_name . ' // ' .
                __('validation.attributes.address') . ': ' . $order->user->address . ' // ' . __('validation.attributes.neighborhood') . ': ' . $order->user->neighborhood . ' // ' .
                __('validation.attributes.phone') . ': ' . $order->user->phone . ' // ' . __('validation.attributes.cellphone') . ': ' . $order->user->cellphone,
            'tools' => [
                'create' => false,
                'reload' => false,
            ],
            'table' => [
                'check' => false,
                'fields' => ['picture', 'name', 'price', 'quantity', 'subtotal'],
                'active' => false,
                'actions' => false,
            ],
            'form' => [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function orderUpdate(Request $request)
    {
        $store = Store::where([['id', $request->store], ['user_id', auth()->id()]])->store()->first();

        if ( is_null($store) ) return abort(404);

        $order = \App\Order::where([['id', $request->order], ['store_id', $store->id]])->store()->first();

        if ( is_null($order) ) return abort(404);

        if (($request->status == 'cancelled' and ($order->status == 'pending' or $order->status == 'dispatched'))
            or $request->status == __('app.selects.orders.status_next.' . $order->status)
        ) {
            $order->status = $request->status;
            $order->save();
        }

        return response()->json([
            'message' => __('app.messages.orders.' . $order->status),
        ]);
    }
}
