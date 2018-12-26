<?php

namespace App\Http\Controllers\Storekeeper;

class CartController extends \App\Http\Controllers\CartController
{
    /**
     * Create a controller instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->cart = \Cart::session('providers_' . auth()->id());

            $request->request->add(['data' => [
                'title' => __('app.titles.storekeeper.cart'),
                'subtitle' => __('app.titles.storekeeper.cart'),
            ]]);

            return $next($request);
        });
    }
}
