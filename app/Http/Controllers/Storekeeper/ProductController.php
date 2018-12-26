<?php

namespace App\Http\Controllers\Storekeeper;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Support\Facades\Auth;

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
        $this->images = 'products';
        $this->user = [ 'store', 'user_id'];
        $this->middleware(function ($request, $next) {
            $this->id = $request->product;
            $this->store = \App\Store::where([['id', $request->store], ['user_id', Auth::id()]])->store()->first();

            if ( !is_null($this->store) ) {
                $request->request->add(['data' => [
                    'title' => __('app.titles.storekeeper.stores'),
                    'subtitle' => __('app.titles.storekeeper.products') . ' - ' . $this->store->full_name,
                ]]);
                $request->request->add(['store_id' => $this->store->id]);
                $this->model = $this->store->products()->with('category')->orderBy('name');

                return $next($request);
            }

            return abort(404);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return parent::show($this->id);
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
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request)
    {
        return parent::updateBase($request, $this->id);
    }
}
