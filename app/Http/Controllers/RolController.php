<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Store;
use Illuminate\Http\Request;

class RolController extends BaseController
{
    private $store;

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
            $this->store = $this->entity->where('user_id', auth()->id())->provider()->first();
            $request->request->add(['data' => [
                'table' => [],
            ]]);
            $request->request->add(['user_id' => auth()->id()]);
            $request->request->add(['provider' => true]);
            $this->model = null;

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
        if ($request->ajax()) return response()->json(is_null($this->store) ? 0 : $this->store->id);

        return view('app.index')->with(array_merge(array_merge([
            'crud' => $this->crud,
            'title' => __('app.titles.providers_rol'),
            'subtitle_form' => __('app.titles.providers_rol'),
        ], $this->entity->getLayout()), $request->input('data') ?? []));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (!is_null($this->store)) return response()->json(['data' => $this->store]);

        $return = parent::storeBase($request, true);

        if (!auth()->user()->hasRole('provider')) {
            auth()->user()->assignRole('provider');
        }

        return $return;
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

    protected function storekeeper()
    {
        if (!auth()->user()->hasRole('storekeeper')) {
            auth()->user()->assignRole('storekeeper');
        }

        return response()->json([
            'message' => __('app.messages.roles.storekeeper'),
        ]);
    }
}
