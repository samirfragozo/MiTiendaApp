<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductRequest;
use App\Product;

class ProductController extends BaseController
{
    private $id;
    private $store;

    /**
     * Create a controller instance.
     *
     * @param Product $entity
     */
    public function __construct(Product $entity)
    {
        parent::__construct($entity);

        $this->crud = 'storekeeper.products';
        $this->user = [ 'store', 'user_id'];
        $this->middleware(function ($request, $next) {
            $this->store = \App\Store::where('user_id', auth()->id())->provider()->first();

            if ( !is_null($this->store) ) {
                $request->request->add(['data' => [
                    'title' => __('app.titles.provider.products'),
                    'subtitle' => __('app.titles.provider.products'),
                ]]);
                $request->request->add(['store_id' => $this->store->id]);
                $this->model = $this->store->products()->with('category')->orderBy('name');

                return $next($request);
            }

            return abort(404);
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        return parent::storeBase($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, int $id)
    {
        return parent::updateBase($request, $id);
    }
}
