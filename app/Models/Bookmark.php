<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'bookmarkable_type', 'bookmarkable_id', 'mobile_app_user_id'
    ];

    public function scopeSearch($query, $search)
    {
        $query->where(function ($q) use ($search) {
            $q->where('products.name', "like", "$search%")
                ->orWhere('suppliers.name', 'like', "$search%")
                ->orWhere('documents.name', 'like', "$search%")
                ->orWhere('products.prefix_id', 'like', "$search%");
        });
    }

    public function ScopeSuppliersIn($query, $suppliers)
    {
        if (!$suppliers) {
            return $query;
        }
        return $query->whereIn('suppliers.id', explode(",", $suppliers));
    }

    public function scopeScanDateBetween($query, $scan_date)
    {
        if ($scan_date &&  $range = explode("/", $scan_date)) {
            $start_date = Carbon::parse($range[0])->startOfDay();
            $end_date = Carbon::parse($range[1])->endOfDay();

            $query->whereBetween('bookmarks.created_at', [$start_date, $end_date]);
        }
        return $query;
    }

    public function scopeOrderByColumn($query, $column = null, $direction = "DESC")
    {
        $columns = ['name' => 'products.name', 'created_at' => 'bookmarks.created_at', 'prefix_id' => 'products.prefix_id'];

        if (array_key_exists($column, $columns)) {
            return $query->orderBy($columns[$column], $direction);
        }

        return $query->orderBy('bookmarks.created_at', $direction ?: 'DESC');
    }
}
