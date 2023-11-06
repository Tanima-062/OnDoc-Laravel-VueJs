<?php

namespace App\Http\Controllers\Web\Category;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Category::query()
            ->when(auth()->user()->type != User::SYSTEM_ADMIN,
                fn($q)=> $q->where('company_id', auth()->user()->company_id),
                fn($q)=> $q->with('company:id,name')
            )
            ->categoryIn(request('category'));

            $categoryQuery = clone $query;

            $categoriesId = $categoryQuery->pluck('id');

            $products = Product::query()
                        ->whereIn('category_id', $categoriesId)
                        ->selectRaw('count(*) as products_count')
                        ->groupBy('category_id')->get()->toArray();
                        ;


            $min_value = 0;
            $max_value = 0;

            if(count($products) > 0){
                $max_value = max($products)['products_count'];

                $start_value = $request->get('start_value', $min_value) ?? 0;
                $end_value = $request->get('end_value', $max_value) ?? $max_value;

                $query->has('products','>=', $start_value)
                    ->has('products', '<=', $end_value)
                    ->withCount('products');
            }else{
                $query->withCount('products');
            }

            $categories = $query->when(in_array(request('order_by'), ['name', 'prefix_id', 'products_count']),
                fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC')),
            )
            ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
                fn($q)=>$q->orderBy(Company::select('name')->whereColumn('categories.company_id', 'companies.id'), request('direction', 'DESC')),
            )
            ->when(!request('order_by'), fn($q)=> $q->orderBy('prefix_id', 'DESC'))
            ->paginate(request('per_page', 15))
            ->withQueryString()
            ->onEachSide(1);

            info($categories);

        return Inertia::render('Categories/Index', [
            'categories'    =>  $categories,
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
        $this->authorize('create', Category::class);

        return Inertia::render('Categories/Create', [
            'prefix_id'     =>  Category::generatePrefixIdByCompanyId(auth()->user()->company_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = Category::create($request->only(['name']) + ['company_id'=>auth()->user()->company_id]);

        return redirect(route('categories.index')) ->with('message', [
            'text' => "Category “:name” successfully created.",
            'attributes' => [
                'name' => $category->name,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return Inertia::render('Categories/Edit',[
            'category'  =>  $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->only('name'));

        return redirect(route('categories.index')) ->with('message', [
            'text' => "Category “:name” successfully updated.",
            'attributes' => [
                'name' => $category->name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect(route('categories.index')) ->with('message', [
            'text' => "Category “:name” was successfully deleted",
            'attributes' => [
                'name' => $category->name,
            ]
        ]);
    }

    public function getFilterData(Request $request)
    {
        $column = $request->column;

        $query = Category::query()
        ->when(auth()->user()->type != User::SYSTEM_ADMIN,
            fn($q)=> $q->where('company_id', auth()->user()->company_id),
            fn($q)=> $q->with('company:id,name')
        )
        ->categoryIn($request->category);

        $categoryQuery = clone $query;

        $categoriesId = $categoryQuery->pluck('id');

        $products = Product::query()
                    ->whereIn('category_id', $categoriesId)
                    ->selectRaw('count(*) as products_count')
                    ->groupBy('category_id')->get()->toArray();

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
            fn($q)=>$q->orderBy(Company::select('name')->whereColumn('categories.company_id', 'companies.id'), request('direction', 'DESC')),
        )
        ->when(!request('order_by'), fn($q)=> $q->orderBy('prefix_id', 'DESC'));

        if ($column == 'category') {
            $ids = $query->pluck('id')->toArray();
            return Category::select('id as value', 'name as label')->whereIn('id', $ids)->orderByRaw("FIELD(id," . implode(", ", $ids) . ")")->get();
        }

        return [];
    }
}
