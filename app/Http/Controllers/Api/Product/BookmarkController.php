<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\BookmarkStoreRequest;
use App\Models\Bookmark;
use App\Models\Document;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookmarkResource;
use App\Models\CompanyUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookmarkController extends Controller
{

    public function index(Request $request)
    {
        $productQuey = Product::select('id', 'name', 'prefix_id', 'company_id', 'status', 'supplier_id', 'public_access', 'serial_number');
        $companies = CompanyUser::where('mobile_app_user_id', $request->user()->id)->pluck('company_id')->toArray();
        $bookmarksQuery = Bookmark::where('mobile_app_user_id', $request->user()->id)
            ->where('products.status', Product::ACTIVE)
            ->leftJoin('documents', fn ($join) => $join->on('bookmarks.bookmarkable_id', '=', 'documents.id')->where('bookmarks.bookmarkable_type', 'App\Models\Document'))
            ->leftJoinSub($productQuey, 'products', fn ($join) => $join->on('products.id', DB::raw('COALESCE(documents.product_id, bookmarks.bookmarkable_id)')))
            ->leftJoin('suppliers', 'products.supplier_id', 'suppliers.id')
            ->orderByColumn($request->order_by, $request->direction)
            ->search($request->search)
            ->suppliersIn($request->supplier)
            ->where(fn($q) => $q->whereIn('products.company_id', $companies)->orWhere('products.public_access', 1))
            ->scanDateBetween($request->scan_date)
            ->selectRaw('bookmarks.*, products.name, products.prefix_id, products.company_id, products.status, products.serial_number, suppliers.name as supplier_name, suppliers.id as supplier_id');

        $suppliers = Bookmark::where('mobile_app_user_id', $request->user()->id)
            ->where('products.status', Product::ACTIVE)
            ->where(fn($q) => $q->whereIn('products.company_id', $companies)->orWhere('products.public_access', 1))
            ->leftJoin('documents', fn ($join) => $join->on('bookmarks.bookmarkable_id', '=', 'documents.id')->where('bookmarks.bookmarkable_type', 'App\Models\Document'))
            ->leftJoinSub($productQuey, 'products', fn ($join) => $join->on('products.id', DB::raw('COALESCE(documents.product_id, bookmarks.bookmarkable_id)')))
            ->leftJoin('suppliers', 'products.supplier_id', 'suppliers.id')
            ->select('suppliers.id', 'suppliers.name')
            ->get()->unique('id')->values();

        $bookmarks = $bookmarksQuery->paginate($request->per_page ?? 10);

        //Adding Docments to the data based on bookmark type
        $products = $bookmarks->where('bookmarkable_type', 'App\\Models\\Product')->pluck('bookmarkable_id')->toArray();
        $documents = $bookmarks->where('bookmarkable_type', 'App\\Models\\Document')->pluck('bookmarkable_id')->toArray();

        $products = Product::whereIn('id', $products)->get();
        $documents = Document::whereIn('id', $documents)->get();

        $bookmarks->where('bookmarkable_type', 'App\\Models\\Product')->each(function ($bookmark) use ($products) {
            $bookmark->documents = $products->find($bookmark->bookmarkable_id)->documents;
        });

        $bookmarks->where('bookmarkable_type', 'App\\Models\\Document')->each(function ($bookmark) use ($documents) {
            $bookmark->document = $documents->find($bookmark->bookmarkable_id);
            $bookmark->document->thumbnail_url = $bookmark->document->image_url;
            $bookmark->document = $bookmark->document->only(['id', 'file_url', 'name', 'created_at', 'thumbnail_url']);
        });

        return BookmarkResource::collection($bookmarks)->additional(['suppliers' => $suppliers]);
    }

    public function show(Request $request, Bookmark $bookmark)
    {
        !$request->user()->can('view', $bookmark) ? throw new NotFoundHttpException("Resource was not found.") : null;

        if ($bookmark->bookmarkable_type == 'App\Models\Product') {
            $product = Product::where('status', Product::ACTIVE)->where('id', $bookmark->bookmarkable_id)->firstOrFail();
            $documents = $product->documents;
        } else {
            $document = Document::findOrFail($bookmark->bookmarkable_id);
            $product = Product::where('status', Product::ACTIVE)->where('id', $document->product_id)->firstOrFail();
            $document->thumbnail_url = $document->image_url;
            $document = $document->only(['id', 'name', 'file_url', 'created_at', 'thumbnail_url']);
        }
        $bookmark->name = $product->name;
        $bookmark->prefix_id = $product->prefix_id;
        $bookmark->serial_number = $product->serial_number;
        $bookmark[isset($document) ? 'document' : 'documents'] = $document ?? $documents;

        return new BookmarkResource($bookmark);
    }

    public function store(BookmarkStoreRequest $request)
    {
        if ($request->type == 'product') {
            $item = Product::find($request->id);
        } else {
            $item = Document::find($request->id);
        }

        if(!$item) {
            throw new NotFoundHttpException("Resource was not found");
        }

        Bookmark::where('mobile_app_user_id', $request->user()->id)->delete();
        $item->bookmarks()->sync([$request->user()->id => ['created_at' => now()]], true);

        $bookmark = Bookmark::where('mobile_app_user_id', $request->user()->id)->where('bookmarkable_id', $item->id)->where('bookmarkable_type', $request->type == 'product' ? 'App\Models\Product' : 'App\Models\Document')->firstOrFail();
        if ($request->type == 'product') {
            $bookmark['name'] = $item->name;
            $bookmark['documents'] = $item->documents;
            $bookmark['prefix_id'] = $item->prefix_id;
            $bookmark['serial_number'] = $item->serial_number;
        } else {
            $bookmark['name'] = $item->product->name;
            $bookmark['document'] = collect($item->toArray())->only(['id', 'file_url', 'name', 'created_at']);
            $bookmark['prefix_id'] = $item->product->prefix_id;
            $bookmark['serial_number'] = $item->product->serial_number;
        }

        return new BookmarkResource($bookmark);
    }

    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();
        return ['status' => 'success'];
    }
}
