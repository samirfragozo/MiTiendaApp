<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * Create a controller instance.
     *
     * @param User $entity
     */
    public function __construct(User $entity)
    {
        parent::__construct($entity);
        $this->user = ['id'];
        $this->middleware(function ($request, $next) {
            $request->request->add(['id' => auth()->id()]);
            $request->request->add(['name' => auth()->user()->name]);
            $request->request->add(['last_name' => auth()->user()->last_name]);
            $request->request->add(['email' => auth()->user()->email]);

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
        if ($request->ajax()) return response()->json(auth()->id());

        return view('app.index')->with(array_merge(array_merge([
            'crud' => $this->crud,
            'title' => __('app.titles.user'),
            'subtitle_form' => __('app.titles.user'),
        ], $this->entity->getLayout()), $request->input('data') ?? []));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, int $id)
    {
        return parent::updateBase($request, $id);
    }
}
