<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BaseController extends Controller
{
    protected $crud;
    protected $entity;
    protected $images;
    protected $model;
    protected $user;

    /**
     * Create a controller instance.
     *
     * @param Model $entity
     */
    protected function __construct(Model $entity)
    {
        $this->entity = $entity;
        $this->crud = $this->entity->getTable();
        $this->model = $this->entity->orderBy('name');
        $this->user = ['user_id'];
        $this->middleware('ajax')->except('debts', 'debtOrders', 'index', 'orders', 'orderProducts');
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
        if ($request->ajax()) return Datatables::of($this->model)->make(true);

        return view('app.index')->with(array_merge(array_merge([
            'crud' => $this->crud,
            'title' => __('app.titles.' . $this->crud),
            'subtitle' => __('app.titles.' . $this->crud),
        ], $this->entity->getLayout()), $request->input('data') ?? []));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $entity = $this->entity->find($id);
        $user = $entity;

        foreach ($this->user as $value) $user = $user->$value;


        if ($user !== auth()->id()) return abort(403);

        return response()->json($entity);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormRequest $request
     * @param bool $reload
     * @return \Illuminate\Http\Response
     */
    protected function storeBase(FormRequest $request, $reload = false)
    {
        $entity = $this->entity->create($request->all());

        $this->image($request, $entity->id);

        return response()->json([
            'data' => $entity,
            'message' => __('base.messages.store', ['name' => $entity->fullName]),
            'reload' => $reload,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    protected function updateBase(FormRequest $request, int $id)
    {
        $entity = $this->entity->find($id);
        $user = $entity;

        foreach ($this->user as $value) $user = $user->$value;

        if ($user !== auth()->id()) return abort(403);

        $entity->fill($request->all());
        $entity->save();

        $this->image($request, $entity->id);

        return response()->json([
            'data' => $entity,
            'message' => __('base.messages.update', ['name' => $entity->fullName]),
        ]);
    }

    /**
     * Change status the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        foreach($request->massive as $item){
            $entity = $this->entity->find($item);
            $user = $entity;

            foreach ($this->user as $value) $user = $user->$value;

            if ($user === auth()->id()) {
                $entity->active = $request->status;
                $entity->save();
            }
        }

        return response()->json([
            'message' => __('base.messages.changeStatus.' . $request->status),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FormRequest $request
     * @param int $id
     * @return void
     */
    protected function image(FormRequest $request, int $id)
    {
        if($request->has('picture')) {
            $file = $request->file('picture');
            $file->move('storage\\' . $this->images, $id . '.' . $file->getClientOriginalExtension());
        }
    }
}
