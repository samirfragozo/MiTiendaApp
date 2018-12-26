<?php

namespace App\Http\Controllers\Storekeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProviderController extends Controller
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
        if ($request->ajax()) return Datatables::of(\App\Store::provider()->active()->orderBy('name'))->make(true);

        return view('app.index')->with([
            'crud' => 'storekeeper.providers',
            'title' => __('app.titles.storekeeper.providers'),
            'subtitle' => __('app.titles.storekeeper.providers'),
            'tools' => [
                'create' => false,
                'reload' => false,
            ],
            'table' => [
                'check' => false,
                'fields' => ['picture', 'name', 'address', 'neighborhood', 'phone', 'cellphone'],
                'active' => false,
                'actions' => true,
            ],
            'form' => [],
        ]);
    }

    /**
     * Display a listing of the products for the provider.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function products(Request $request)
    {
        $store = \App\Store::where('id', $request->provider)->provider()->active()->first();

        if ( is_null($store) ) return abort(404);

        if ($request->ajax()) return Datatables::of($store->products()->active()->with('category')->orderBy('name'))->make(true);

        return view('app.index')->with([
            'crud' => 'products',
            'title' => __('app.titles.storekeeper.providers'),
            'subtitle' => __('app.titles.products') . ' - ' . $store->full_name,
            'tools' => [
                'create' => false,
                'reload' => false,
            ],
            'table' => [
                'check' => false,
                'fields' => ['picture', 'name', 'price', 'category_id', 'description'],
                'active' => false,
                'actions' => true,
            ],
            'form' => [],
        ]);
    }
}
