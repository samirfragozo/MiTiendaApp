<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CartController extends Controller
{
    protected $cart;
    private $product;

    /**
     * Create a controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('ajax')->except('index');
        $this->middleware(function ($request, $next) {
            $this->cart = \Cart::session('stores_' . auth()->id());

            if ($request->product) {
                if ($request->store) {
                    $store = \App\Store::where('id', $request->store)->active()->first();

                    if (is_null($store)) return abort(404);

                    $this->product = \App\Product::where([['id', $request->product], ['store_id', $store->id]])->active()->first();

                } else {
                    $this->product = \App\Product::where('id', $request->product)->active()->first();
                }

                if (is_null($this->product)) return abort(404);
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $cart_content = $this->cart->getContent()->toArray();
            $products = \App\Product::orderBy('name')->with('store')->find(array_keys($cart_content))->sortBy('store.name');
            $products = $products->map(function ($product) use ($cart_content) {
                $product->quantity = $cart_content[$product->id]['quantity'];
                $product->subtotal = $cart_content[$product->id]['quantity'] * $product->price;

                return $product;
            });

            return Datatables::of($products)->make(true);
        }

        return view('app.index')->with(array_merge([
            'crud' => 'cart',
            'title' => __('app.titles.cart'),
            'subtitle' => __('app.titles.cart'),
            'tools' => [
                'create' => false,
                'reload' => true,
            ],
            'table' => [
                'check' => false,
                'fields' => ['picture', 'name', 'store_id', 'price', 'quantity', 'subtotal'],
                'active' => false,
                'actions' => true,
            ],
            'form' => [],
        ], $request->input('data') ?? []));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    protected function store()
    {
        $cart_content = $this->cart->getContent()->toArray();
        $stores = \App\Product::orderBy('name')->with('store')->find(array_keys($cart_content))->groupBy('store.id');

        foreach ($stores as $id => $products) {
            $order = \App\Order::create([
                'user_id' => auth()->id(),
                'store_id' => $id,
            ]);

            foreach ($products as $product) {
                $order->products()->attach($product->id, [
                    'quantity' => $cart_content[$product->id]['quantity'],
                    'historical_price' => $product->price,
                    'subtotal' => $cart_content[$product->id]['quantity'] * $product->price,
                ]);
            }
        }

        $this->cart->clear();

        return response()->json([
            'message' => trans_choice('app.messages.cart.order', count($stores), ['value' => count($stores)])
        ]);
    }

    public function add()
    {
        if (is_null($this->cart->get($this->product->id))) {
            $this->product->quantity = 1;
            $this->cart->add($this->product->attributesToArray());
        }

        return response()->json(__('app.messages.cart.add', ['name' => $this->product->name]));
    }

    public function minus()
    {
        return response()->json([
            $this->cart->update($this->product->id, ['quantity' => -1]),
        ]);
    }

    public function plus()
    {
        return response()->json([
            $this->cart->update($this->product->id, ['quantity' => 1]),
        ]);
    }

    public function remove()
    {
        $this->cart->remove($this->product->id);

        return response()->json([
            'message' => __('app.messages.cart.remove', ['name' => $this->product->name]),
        ]);
    }
}
