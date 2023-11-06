<?php

namespace App\Http\Controllers\Web\Supplier;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\CreateSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Product;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Supplier::query()
        ->select('id','prefix_id', 'name','company_id')
        ->when(auth()->user()->type != User::SYSTEM_ADMIN,
            fn($q)=> $q->where('company_id', auth()->user()->company_id),
            fn($q)=> $q->with('company:id,name')
        )
        ->supplierIn(request('supplier'));

        $supplierQuery = clone $query;

        $suppliersId = $supplierQuery->pluck('id');

        $products = Product::query()
        ->whereIn('supplier_id', $suppliersId)
        ->selectRaw('count(*) as products_count')
        ->groupBy('supplier_id')->get()->toArray();
        ;


        $min_value = 0;
        $max_value = 0;

        if(count($products) > 0){
            $max_value = max($products)['products_count'];
            $min_value = 0;

            $start_value = $request->get('start_value', $min_value) ?? 0;
            $end_value = $request->get('end_value', $max_value) ?? $max_value;

            $query->has('products','>=', $start_value)
                ->has('products', '<=', $end_value)
                ->withCount('products');
        }else{
            $query->withCount('products');
        }



        $suppliers = $query->when(in_array(request('order_by'), ['name', 'prefix_id', 'products_count']),
                        fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC')),
                    )
                    ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
                        fn($q)=>$q->orderBy(Company::select('name')->whereColumn('suppliers.company_id', 'companies.id'), request('direction', 'DESC')),
                    )
                    ->when(!request('order_by'), fn($q)=> $q->orderBy('prefix_id', 'DESC'))
                    ->paginate(request('per_page', 15))
                    ->withQueryString()
                    ->onEachSide(1);

        return Inertia::render('Suppliers/Index', [
            'suppliers' =>  $suppliers,
            'minValue'  =>  $min_value,
            'maxValue'  =>  $max_value
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Supplier::class);

        return Inertia::render('Suppliers/Create', [
            'prefix_id'     =>  Supplier::generatePrefixIdByCompanyId(auth()->user()->company_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupplierRequest $request)
    {
        $supplier = Supplier::create($request->except('prefix_id')  + ['company_id'=> auth()->user()->company_id]);

        return redirect(route('suppliers.index'))->with('message', [
            'text' => "Supplier “:name” was successfully created",
            'attributes' => [
                'name' => $supplier->name,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $this->authorize('update', $supplier);

        return Inertia::render('Suppliers/Edit',[
            'supplier'  =>  $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->except('prefix_id'));

        return redirect(route('suppliers.index'))->with('message', [
            'text' => "Supplier “:name” was successfully updated",
            'attributes' => [
                'name' => $supplier->name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $this->authorize('delete', $supplier);

        $supplier->delete();

        return redirect(route('suppliers.index'))->with('message', [
            'text' => "Supplier “:name” was successfully deleted",
            'attributes' => [
                'name' => $supplier->name,
            ]
        ]);
    }

    public function getFilterData(Request $request)
    {
        $start_value = $request->get('start_value');
        $end_value = $request->get('end_value');
        $column = $request->column;

        $query = Supplier::query()
        ->select('id','prefix_id', 'name')
        ->when(auth()->user()->type != User::SYSTEM_ADMIN,
            fn($q)=> $q->where('company_id', auth()->user()->company_id),
            fn($q)=> $q->with('company:id,name')
        )
        ->supplierIn(request('supplier'));

        $supplierQuery = clone $query;

        $suppliersId = $supplierQuery->pluck('id');

        $products = Product::query()
                    ->whereIn('supplier_id', $suppliersId)
                    ->selectRaw('count(*) as products_count')
                    ->groupBy('supplier_id')->get()->toArray();
                    ;


        $min_value = 0;
        $max_value = 0;

        if(count($products) > 0){
            $max_value = max($products)['products_count'];
            $min_value = 0;

            $start_value = $request->get('start_value', $min_value) ?? 0;
            $end_value = $request->get('end_value', $max_value) ?? $max_value;

            $query->has('products','>=', $start_value)
                ->has('products', '<=', $end_value)
                ->withCount('products');
        }else{
            $query->withCount('products');
        }


        $query->when(in_array(request('order_by'), ['name', 'prefix_id', 'products_count']),
            fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC')),
        )
        ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
            fn($q)=>$q->orderBy(Company::select('name')->whereColumn('suppliers.company_id', 'companies.id'), request('direction', 'DESC')),
        )
        ->when(!request('order_by'), fn($q)=> $q->orderBy('prefix_id', 'DESC'));

        if ($column == 'supplier') {
            $ids = $query->pluck('id')->toArray();
            return Supplier::select('id as value', 'name as label')->whereIn('id', $ids)->orderByRaw("FIELD(id," . implode(", ", $ids) . ")")->get();
        }

        return [];
    }
}
