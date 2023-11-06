<?php

namespace App\Models;

use App\Traits\CompanyWisePrefixID;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\CompanyWisePrefixIDContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model implements CompanyWisePrefixIDContract
{
    use HasFactory, CompanyWisePrefixID;

    protected $fillable = [
        'prefix_id','company_id', 'name'
    ];

    const PREFIX = 'CAT';

    public static function getPrefix(): string
    {
        return self::PREFIX;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeOrderColumn($query, $column = 'created_at', $order='DESC')
    {
        $query->orderBy($column, $order);
    }

    public function scopeCategoryIn($query, $categories)
    {
        if ($categories) {
            $categories = explode(",", $categories);
            return $query->whereIn('id', $categories);
        }
        return $query;
    }
}
