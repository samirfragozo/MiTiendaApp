<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    private $store;

    /**
     * Create a controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->store = \App\Store::where('user_id', auth()->id())->provider()->first();

            if ( is_null($this->store) ) return abort(404);

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) return Datatables::of($this->store->orders()->with('user')->orderBy('created_at', 'desc'))->make(true);

        return view('app.index')->with([
            'crud' => 'storekeeper.orders',
            'title' => __('app.titles.storekeeper.stores'),
            'subtitle' => __('app.titles.storekeeper.orders') . ' - ' . $this->store->full_name,
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
    public function products(Request $request)
    {
        $order = \App\Order::where([['id', $request->order], ['store_id', $this->store->id]])->provider()->first();

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
    public function update(Request $request)
    {

        $order = \App\Order::where([['id', $request->order], ['store_id', $this->store->id]])->provider()->first();

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
