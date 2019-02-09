<?php

namespace App\Http\Controllers\Storekeeper;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PaymentRequest;
use App\Payment;
use App\Product;
use Illuminate\Support\Facades\Auth;

class PaymentController extends BaseController
{
    private $id;
    private $store;

    /**
     * Create a controller instance.
     *
     * @param Payment $entity
     */
    public function __construct(Payment $entity)
    {
        parent::__construct($entity);

        $this->crud = 'storekeeper.payments';
        $this->user = ['store', 'user_id'];
        $this->middleware(function ($request, $next) {
            $this->id = $request->payment;
            $this->store = \App\Store::where([['id', $request->store], ['user_id', Auth::id()]])->store()->first();
            $user = \App\User::find($request->user);

            if ( !is_null($this->store) ) {
                $request->request->add(['data' => [
                    'title' => __('app.titles.storekeeper.stores'),
                    'subtitle' => __('app.titles.storekeeper.payments') . ' - ' . $user->full_name . ' - ' . $this->store->full_name,
                ]]);
                $request->request->add(['store_id' => $this->store->id]);
                $request->request->add(['user_id' => $user->id]);
                $this->model = $this->entity->where([['user_id', $user->id], ['store_id', $this->store->id]])->with('user')->orderBy('created_at', 'desc');

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
     * @param PaymentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {
        return parent::storeBase($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRequest $request)
    {
        return parent::updateBase($request, $this->id);
    }
}
