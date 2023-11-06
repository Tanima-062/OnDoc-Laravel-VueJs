<?php

namespace App\Models;

use App\Traits\CompanyWisePrefixID;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\CompanyWisePrefixIDContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model implements CompanyWisePrefixIDContract
{
    use HasFactory, CompanyWisePrefixID;

    protected $fillable = [
        'prefix_id', 'company_id', 'name', 'street', 'house_number', 'postal_code', 'city', 'country_code', 'contact_persion_name', 'contact_persion_email'
    ];

    const PREFIX = 'SUP';

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

    public function scopeSupplierIn($query, $suppliers)
    {
        if ($suppliers) {
            $suppliers = explode(",", $suppliers);
            return $query->whereIn('id', $suppliers);
        }
        return $query;
    }
}
