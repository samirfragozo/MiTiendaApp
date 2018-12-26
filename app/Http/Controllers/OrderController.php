<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) return Datatables::of(auth()->user()->orders()->store()->with('store')->orderBy('created_at', 'desc'))->make(true);

        return view('app.index')->with([
            'crud' => 'orders',
            'title' => __('app.titles.orders'),
            'subtitle' => __('app.titles.orders'),
            'tools' => [
                'create' => false,
                'reload' => true,
            ],
            'table' => [
                'check' => false,
                'fields' => ['created_at', 'store_id', 'quantity', 'total', 'status'],
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
        $order = \App\Order::where([['id', $request->order], ['user_id', auth()->id()]])->store()->first();

        if ( is_null($order) ) return abort(404);

        if ($request->ajax()) return Datatables::of($order->products()->orderBy('name'))->make(true);

        return view('app.index')->with([
            'crud' => 'order_product',
            'title' => __('app.titles.orders'),
            'subtitle' => $order->created_at . ' - ' . $order->store->full_name . ' - $ ' . $order->total,
            'tools' => [
                'create' => false,
                'reload' => false,
            ],
            'filters' => [],
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
    protected function update(Request $request)
    {
        $order = \App\Order::where([['id', $request->order], ['user_id', auth()->id()]])->store()->first();

        if ( is_null($order) ) return abort(404);

        $order->status = 'cancelled_user';
        $order->save();

        return response()->json([
            'message' => __('app.messages.orders.cancelled_user'),
        ]);
    }
}
