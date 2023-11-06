<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Database\Eloquent\SoftDeletes;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class MobileAppUser extends Authenticatable
{
    use HasFactory, HasApiTokens, SoftDeletes, Notifiable;

    // public const STATUS_ACTIVE = 'active';
    // public const STATUS_INACTIVE = 'inactive';
    // public const STATUS_PENDING = 'pending';
    // public const STATUS_NEW = 'new';

    // const PREFIX = 'MAB';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'street', 'zip_code', 'house_number', 'city', 'country', 'company', 'country_iso_code', 'phone_number', 'full_phone_number', 'password', 'email_verified_at', 'verification_token', 'language_id', 'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'deleted_at',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // $user->prefix_id = nextId('mobile_app_users', self::PREFIX);
            // set full phone number
            try {
                $user->full_phone_number = PhoneNumber::make($user->phone_number, $user->country_iso_code)->formatE164();
            } catch (\Throwable $th) {
                $user->full_phone_number = null;
            }
        });

        static::updating(function ($user) {
            // set full phone number
            try {
                $user->full_phone_number = PhoneNumber::make($user->phone_number, $user->country_iso_code)->formatE164();
            } catch (\Throwable $th) {
                $user->full_phone_number = null;
            }
        });

        static::deleting(function ($user) {
            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->where('tokenable_type', MobileAppUser::class)->delete();
            DB::table('mobile_password_resets')->where('mobile_app_user_id', $user->id)->delete();
        });
    }

    public function bookmarkedDocuments(): MorphToMany
    {
        return $this->morphedByMany(Document::class, 'bookmarkable', 'bookmarks')->withTimestamps();
    }

    public function bookmarkedProducts(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'bookmarkable', 'bookmarks')->withTimestamps();
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return null;
        }

        else if (preg_match("@http@", $this->photo)) {
            return $this->photo;
        }

        else if(config('filesystems.default')  == 'exoscale' ||  env('FILESYSTEM_DISK') == 'exoscale' ){
            return Storage::disk('exoscale')->publicUrl($this->photo);
        }

        return Storage::disk('public')->url($this->photo);
    }

    //relations
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_user', 'mobile_app_user_id', 'company_id')
            ->withPivot(['id', 'company_id', 'mobile_app_user_id', 'status'])
            ->withTimestamps()
            ->using(CompanyUser::class);
    }

    //scopes

    public function scopeActive($query)
    {
        // return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeOrderByColumn($query, $column = null, $direction = 'DESC')
    {
        $self_columns = [...$this->fillable];
        if ($column && $direction && in_array($column, $self_columns)) {
            return $query->orderBy("mobile_app_users.$column", $direction)
                ->orderBy('mobile_app_users.created_at', $direction)
                ->orderBy('mobile_app_users.id', $direction);
        }

        if ($column == 'company') {
            return $query->orderBy('companies.name')
                ->orderBy('mobile_app_users.created_at', $direction)
                ->orderBy('mobile_app_users.id', $direction);
        }
        if ($column == 'status') {
            return $query->orderBy('company_user.status', $direction)
                ->orderBy('mobile_app_users.created_at', $direction)
                ->orderBy('mobile_app_users.id', $direction);
        }

        if ($column == 'prefix_id') {
            return $query->orderBy('company_user.prefix_id', $direction)
                ->orderBy('mobile_app_users.created_at', $direction)
                ->orderBy('mobile_app_users.id', $direction);
        }
        return $query->orderBy('mobile_app_users.created_at', 'desc')->orderBy('mobile_app_users.id', 'desc');
    }

    public function scopeCompanyJoin($q, $company_id = null)
    {
        return $q->join('company_user', fn ($q) => $q->on('company_user.mobile_app_user_id', '=', 'mobile_app_users.id')->where('company_user.company_id', '=', $company_id))
            ->join('companies', fn ($q) => $q->on('companies.id', '=', 'company_user.company_id'));
    }

    public function scopeStatusIn($query, $status)
    {
        $status =  $status ? explode(",", $status) : null;
        if (!$status)
            return $query;

        return $query->whereIn('company_user.status', $status);
    }

    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class);
    }
}
