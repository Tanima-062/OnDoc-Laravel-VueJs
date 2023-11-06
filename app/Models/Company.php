<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,'prefix_id', 'logo', 'street', 'house_number', 'postal_code', 'city', 'country_code', 'contact_persion_first_name', 'contact_persion_last_name', 'contact_persion_email', 'country_iso_code', 'phone_number', 'full_phone_number', 'status'
    ];

    const PREFIX = 'CO';

    public static function boot(){
        parent::boot();

        static::creating(function($company){
            $company->prefix_id =nextId('companies', self::PREFIX);
        });

        static::addGlobalScope('system', function($q){
            // $q->where('name', '!=', 'system');
        });
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'company_id');
    }

    public function mobileAppUsers(): BelongsToMany
    {
        return $this->belongsToMany(MobileAppUser::class, 'company_user', 'company_id', 'mobile_app_user_id')
        ->withPivot(['id', 'company_id', 'mobile_app_user_id', 'status'])
        ->withTimestamps()
        ->using(CompanyUser::class)
        ;
    }

    public function scopeStatusIn($query, $status)
    {
        if ($status) {
            $status = explode(",", $status);
            return $query->whereIn('status', $status);
        }
        return $query;
    }



    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }

        else if (preg_match("@http@", $this->logo)) {
            return $this->logo;
        }

        else if(config('filesystems.default')  == 'exoscale' ||  env('FILESYSTEM_DISK') == 'exoscale' ){
            return Storage::disk('exoscale')->publicUrl($this->logo);
        }

        return Storage::disk('public')->url($this->logo);
    }
}
