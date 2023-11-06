<?php

namespace App\Models;

use App\Traits\HasPermission;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasPermission;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    const SYSTEM_ADMIN = 'system_admin';
    const COMPANY_ADMIN = 'company_admin';
    const COMPANY_SUB_ADMIN = 'company_sub_admin';

    const COMPANY_ADMIN_PREFIX = 'CA';
    const COMPANY_SUB_ADMIN_PREFIX = 'CSA';



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prefix_id',
        'language_id',
        'company_id',
        'first_name',
        'last_name',
        'email',
        'avatar',
        'email_verified_at',
        'password',
        'type',
        'verification_token',
        'status',
        'permission',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'status' => 'boolean',
    ];

    protected $appends = ['name', 'user_type'];

    public static function boot(){
        parent::boot();

        static::creating(function($user){
            $user->prefix_id =  self::getPrefixIdByCompany($user->type, $user);
            $user->permission = $user->type == 'company_admin' ? 'full' : 'view';
        });
    }

    public static function getPrefixIdByCompany($type, $user){
        $last_id = 1;
        $prefix = $type == 'company_admin' ? self::COMPANY_ADMIN_PREFIX : self::COMPANY_SUB_ADMIN_PREFIX;

        if($last_supplier = self::where('company_id', $user->company_id)->where('type', $type)->orderBy('prefix_id', 'DESC')->first()){
            sscanf($last_supplier->prefix_id, $prefix."%05d", $num);
            if($num){
                $last_id = $num + 1;
            }
        }

        return sprintf("%s%05d", $prefix, $last_id);
    }


    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAvatarUrlAttribute()
    {
        if (is_null($this->avatar)) {
            return asset("images/avatar.png");
        }

        else if (preg_match("@http@", $this->avatar)) {
            return $this->avatar;
        }

        else if(config('filesystems.default')  == 'exoscale' ||  env('FILESYSTEM_DISK') == 'exoscale' ){
            return Storage::disk('exoscale')->publicUrl($this->avatar);
        }

        return Storage::disk('public')->url($this->avatar);
    }

    public function getUserTypeAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->type));
    }


    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }


    public function resetToken()
    {
        $column_name = $this->user_medium == "phone" ? "phone_number" : "email";

        return $this->hasOne(PasswordReset::class, $column_name, $column_name);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function scopeStatusIn($query, $status)
    {
        $status =  $status ? explode(",", $status) : null;
        if (!$status)
            return $query;

        return $query->whereIn('status', $status);
    }

    public function scopeUserTypeIn($query, $type)
    {
        $type =  $type ? explode(",", $type) : null;
        if (!$type)
            return $query;

        return $query->whereIn('type', $type);
    }

    public function scopeCompanyIn($query, $companies)
    {
        if ($companies) {
            $companies = explode(",", $companies);
            return $query->whereIn('company_id', $companies);
        }
        return $query;
    }
}
