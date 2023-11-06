<?php

namespace App\Http\Controllers\Web\Product;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\Document;
use App\Models\Supplier;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Exports\Products\ProductReports;
use App\Jobs\DocumentThumbnailGenerator;
use App\Jobs\ProductPDFGenerator;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use QrCode;
use PDF;
class ProductController extends Controller
{
    use UploadAble;

    /**
     *
     * @return void
     */
    public function index(Request $request)
    {
        $productQuery= Product::query()
            ->select('id','name', 'status', 'prefix_id', 'supplier_id', 'category_id', 'company_id', 'serial_number')
            ->with(['category:id,name', 'supplier:id,name'])
            ->when(auth()->user()->type != User::SYSTEM_ADMIN,
                fn($q)=> $q->where('company_id', auth()->user()->company_id),
                fn($q)=> $q->with('company:id,name')
            );

        $productQueryClone = clone $productQuery;

        $products = $productQuery->statusIn($request->status)
            ->supplierIn($request->supplier)
            ->categoryIn($request->category)
            ->when(in_array(request('order_by'), ['prefix_id', 'name','serial_number', 'supplier', 'category', 'status']),
                fn($q)=>$q->orderByColumn($request->order_by, $request->direction),
            )
            ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
                fn($q)=>$q->orderBy(Company::select('name')->whereColumn('products.company_id', 'companies.id'), request('direction', 'DESC')),
            )
            ->when(!request('order_by'), fn($q)=> $q->orderBy('prefix_id', 'DESC'))
            ->paginate(request('per_page', 15))
            ->withQueryString()
            ->onEachSide(1);

        $is_more_than_1000_product = $productQueryClone->count() > 1000 ? true : false;

        return Inertia::render('Products/Index', ['products' => $products, 'is_more_than_1000_product' => $is_more_than_1000_product]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Products/Show', ['product' => new ProductResource($product->load(['supplier:id,name', 'category:id,name', 'documents']))]);
    }

    public function create()
    {
        $this->authorize('create', Product::class);

        $categories_count = Category::where('company_id', auth()->user()->company_id)->count();
        $suppliers_count = Supplier::where('company_id', auth()->user()->company_id)->count();

        if($categories_count == 0 && $suppliers_count == 0){
            return redirect(route('products.index')) ->with('message', [
                'text' => "Please Add At Least One Supplier And One Category To Add A Product Document",
            ]);
        }elseif($categories_count == 0){
            return redirect(route('products.index')) ->with('message', [
                'text' => "Please Add At Least One Category To Add A Product Document",
            ]);
        }elseif($suppliers_count == 0){
            return redirect(route('products.index')) ->with('message', [
                'text' => "Please Add At Least One Supplier To Add A Product Document",
            ]);
        }

        $latest_id = Product::generatePrefixIdByCompanyId(auth()->user()->company_id);
        $suppliers = Supplier::select('id as value', 'name as label')->where('company_id', auth()->user()->company_id)->orderBy('name', 'asc')->get();
        $categories = Category::select('id as value', 'name as label')->where('company_id', auth()->user()->company_id)->orderBy('name', 'asc')->get();
        return Inertia::render('Products/Create', [
            'suppliers' => $suppliers,
            'categories' => $categories,
            'latest_id' => $latest_id
        ]);
    }

    public function fileUpload(Request $request)
    {
        $filepath = $this->uploadOne($request->file, 'temp', getDisk());
        return $filepath;
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all() + ['user_id' => auth()->id(), 'company_id' => auth()->user()->company_id]);

        $documents = [];

        if (is_array($request->technical)) {
            $documents = $this->documentsPush($request->technical, 'technical', $documents, $product->id);
        }
        if (is_array($request->supplier)) {
            $documents = $this->documentsPush($request->supplier, 'supplier', $documents, $product->id);
        }
        if (is_array($request->drawing)) {
            $documents = $this->documentsPush($request->drawing, 'drawing', $documents, $product->id);
        }
        if (is_array($request->instruction)) {
            $documents = $this->documentsPush($request->instruction, 'instruction', $documents, $product->id);
        }
        if (is_array($request->modification_guide)) {
            $documents = $this->documentsPush($request->modification_guide, 'modification_guide', $documents, $product->id);
        }

        DB::table('documents')->insert($documents);
        DocumentThumbnailGenerator::dispatch($product);

        return redirect(route('products.index')) ->with('message', [
            'text' => "Product “:name” has created successfully",
            'attributes' => [
                'name' => $product->name
            ]
        ]);

    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $product = Product::with('documents')->where('id', $product->id)->first();
        $suppliers = Supplier::select('id as value', 'name as label')->where('company_id', auth()->user()->company_id)->orderBy('name', 'asc')->get();
        $categories = Category::select('id as value', 'name as label')->where('company_id', auth()->user()->company_id)->orderBy('name', 'asc')->get();
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'suppliers' => $suppliers,
            'categories' => $categories
        ]);
    }

    private function documentsPush($request_documents, $section, array $documents, $productId)
    {
        foreach ($request_documents as $doc) {

            if (is_null($doc['file'])) {
                continue;
            }

            if(isset($doc['doc_id'])){
                if ($doc['doc_type'] == 'file') {
                    $filename = pathinfo($doc['file'], PATHINFO_BASENAME);
                    $filepath = sprintf("products/%s/%s/%s", $productId, $section, $filename);
                    if(file_exists($filepath)){
                        Storage::disk(getDisk())->move($doc['file'], $filepath);
                    }
                    $doc['file'] = $filepath;
                }
                Document::where('id', $doc['doc_id'])->update(['name' => $doc['name'], 'type' => $doc['doc_type'], 'filepath' => $doc['file']]);
                continue;
            }

            if ($doc['doc_type'] == 'file') {
                $filename = pathinfo($doc['file'], PATHINFO_BASENAME);
                $filepath = sprintf("products/%s/%s/%s", $productId, $section, $filename);
                Storage::disk(getDisk())->move($doc['file'], $filepath);
                $doc['file'] = $filepath;
            }

            array_push($documents, [
                'product_id'    => $productId,
                'section'       => $section,
                'name'          => $doc['name'],
                'type'          => $doc['doc_type'],
                'filepath'      => $doc['file'],
                'disk'          => getDisk(),
                'user_id'       => auth()->id(),
                'company_id'    => auth()->user()->company_id,
                'created_at'    =>  now(),
                'updated_at'    =>  now()
            ]);
        }

        return $documents;
    }

    public function updateStatus(Request $request, Product $product)
    {
        $request->validate(['status' => 'in:active,inactive']);
        $product->update(
            ['status' => $request->status],
        );

        $statusText = $request->status == 'inactive' ? 'Deactivated' : 'Activated';
        $message = trans("Product “:name” has $statusText", ['name' => $product->name]);
        return redirect()->back()->with('message', $message);
    }

    public function getFilterData(Request $request)
    {
        $column = $request->column;
        $query = Product::query()
            ->select('id','name', 'status', 'prefix_id', 'supplier_id', 'category_id', 'company_id')
            ->with(['category:id,name', 'supplier:id,name'])
            ->when(auth()->user()->type != User::SYSTEM_ADMIN,
                fn($q)=> $q->where('company_id', auth()->user()->company_id),
                fn($q)=> $q->with('company:id,name')
            )
            ->statusIn($request->status)
            ->supplierIn($request->supplier)
            ->categoryIn($request->category)
            ->when(in_array(request('order_by'), ['prefix_id', 'name','serial_number', 'supplier', 'category', 'status']),
                fn($q)=>$q->orderByColumn($request->order_by, $request->direction),
            )
            ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
                fn($q)=>$q->orderBy(Company::select('name')->whereColumn('products.company_id', 'companies.id'), request('direction', 'DESC')),
            )
            ->when(!request('order_by'), fn($q)=> $q->orderBy('prefix_id', 'DESC'));

        if ($column == 'status') {
            $status = $query->pluck('status')->unique()->values()->map(function ($status) {
                if ($status) {
                    return ['label' => ucfirst($status), 'value' => $status];
                }
            });
            return $status;
        }

        if ($column == 'supplier') {
            $ids = $query->whereNotNull('supplier_id')->pluck('supplier_id')->unique()->values()->toArray();
            return Supplier::select('id as value', 'name as label')->whereIn('id', $ids)->orderByRaw("FIELD(id," . implode(", ", $ids) . ")")->get();
        }

        if ($column == 'category') {
            $ids = $query->whereNotNull('category_id')->pluck('category_id')->unique()->values()->toArray();
            return Category::select('id as value', 'name as label')->whereIn('id', $ids)->orderByRaw("FIELD(id," . implode(", ", $ids) . ")")->get();
        }

        return [];
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        DB::table('products')->where('id', $product->id)->update([
            'serial_number' => $request->serial_number,
            'category_id'   => $request->category_id,
            'supplier_id'   => $request->supplier_id,
            'name'          => $request->name,
            'public_access' => $request->public_access,
            'warranty_start_date' => $request->warranty_start_date,
            'warranty_end_date'   => $request->warranty_end_date
        ]);

        $doc_ids = [];
        $documents = [];

        if (is_array($request->technical)) {
            $ids = array_filter(array_column($request->technical, 'doc_id'));
            foreach($ids as $id){
                array_push($doc_ids, $id);
            }
            $documents = $this->documentsPush($request->technical, 'technical', $documents, $product->id);
        }
        if (is_array($request->supplier)) {
            $ids = array_filter(array_column($request->supplier, 'doc_id'));
            foreach($ids as $id){
                array_push($doc_ids, $id);
            }
            $documents = $this->documentsPush($request->supplier, 'supplier', $documents, $product->id);
        }
        if (is_array($request->drawing)) {
            $ids = array_filter(array_column($request->drawing, 'doc_id'));
            foreach($ids as $id){
                array_push($doc_ids, $id);
            }
            $documents = $this->documentsPush($request->drawing, 'drawing', $documents, $product->id);
        }
        if (is_array($request->instruction)) {
            $ids = array_filter(array_column($request->instruction, 'doc_id'));
            foreach($ids as $id){
                array_push($doc_ids, $id);
            }
            $documents = $this->documentsPush($request->instruction, 'instruction', $documents, $product->id);
        }
        if (is_array($request->modification_guide)) {
            $ids = array_filter(array_column($request->modification_guide, 'doc_id'));
            foreach($ids as $id){
                array_push($doc_ids, $id);
            }
            $documents = $this->documentsPush($request->modification_guide, 'modification_guide', $documents, $product->id);
        }

        $prevDocuments = Document::where('product_id', $product->id)->whereNotNull('image_path')->select('image_path', 'disk')->get()->toArray();


        Document::where('product_id', $product->id)->whereNotIn('id', $doc_ids)->delete();
        Document::insert($documents);
        DocumentThumbnailGenerator::dispatch($product, $prevDocuments);

        return redirect(route('products.index')) ->with('message', [
            'text' => "Product “:name” has updated successfully",
            'attributes' => [
                'name' => $product->name
            ]
        ]);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // $this->authorize('delete', $supplier);

        $product->delete();

        return redirect()->back()->with('message', [
            'text' => "Successfully deleted the product",
            // 'attributes' => [
            //     'name' => $product->name,
            // ]
        ]);
    }




    /**
     * Export products data
     *
     * @return void
     */
    public function export()
    {
        $data = Product::query()
            ->with('category:id,name', 'supplier:id,name')
            ->select('id', 'prefix_id', 'name', 'serial_number', 'status','supplier_id', 'category_id')
            ->where('company_id', auth()->user()->company_id)
            ->get();

        // return $data;
        // dd($data);

        return Excel::download(new ProductReports($data) ,'product-reports.xlsx');
    }

    public function getPdf(){
        ProductPDFGenerator::dispatch(auth()->user());
        return response()->json(trans('OnDoc is processing your requested PDF and will send to your email :_userEmail once ready', ["_userEmail" => auth()->user()->email]));
    }
}
