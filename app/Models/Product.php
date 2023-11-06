<?php

namespace App\Models;

use App\Traits\CompanyWisePrefixID;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\CompanyWisePrefixIDContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements CompanyWisePrefixIDContract
{
    use HasFactory, SoftDeletes, CompanyWisePrefixID;

    protected $fillable = [
        'prefix_id', 'serial_number', 'name', 'company_id', 'category_id', 'supplier_id', 'user_id', 'public_access', 'status', 'warranty_start_date', 'warranty_end_date'
    ];

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';
    const PREFIX = 'PR';

    public static function getPrefix(): string
    {
        return self::PREFIX;
    }

    protected $casts = [
        'public_access'   =>    'boolean'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'product_id');
    }

    public function bookmarks(): MorphToMany
    {
        return $this->morphToMany(MobileAppUser::class, 'bookmarkable', 'bookmarks')->withTimestamps();
    }

    public function scopeOrderByColumn($query, $column = null, $direction = 'DESC')
    {
        $self_columns = [...$this->fillable];
        if ($column && $direction && in_array($column, $self_columns)) {
            return $query->orderBy($column, $direction);
        }

        if ($column == 'category') {
            $query->orderBy(Category::whereColumn('products.category_id', 'categories.id')->select('name'), $direction)
                ->orderBy('created_at', $direction)
                ->orderBy('id', $direction);
        }
        if ($column == 'supplier') {
            $query->orderBy(Supplier::whereColumn('products.supplier_id', 'suppliers.id')->select('name'), $direction)
                ->orderBy('created_at', $direction)
                ->orderBy('id', $direction);
        }
        return $query->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function scopeStatusIn($query, $status)
    {
        if ($status) {
            $status = explode(",", $status);
            return $query->whereIn('status', $status);
        }
        return $query;
    }

    public function scopeCategoryIn($query, $categories)
    {
        if ($categories) {
            $categories = explode(",", $categories);
            return $query->whereIn('category_id', $categories);
        }
        return $query;
    }

    public function scopeSupplierIn($query, $suppliers)
    {
        if ($suppliers) {
            $suppliers = explode(",", $suppliers);
            return $query->whereIn('supplier_id', $suppliers);
        }
        return $query;
    }
}
