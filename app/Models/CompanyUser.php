<?php

namespace App\Models;

use App\Contracts\CompanyWisePrefixIDContract;
use App\Traits\CompanyWisePrefixID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyUser extends Pivot implements CompanyWisePrefixIDContract
{
    use HasFactory, CompanyWisePrefixID;

    protected $table = 'company_user';

    protected $fillable = [
        'prefix_id', 'company_id', 'mobile_app_user_id', 'status'
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_PENDING = 'pending';

    const PREFIX = 'MAB';

    public static function getPrefix(): string
    {
        return self::PREFIX;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(MobileAppUser::class, 'mobile_app_user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeCompanyIn($query, $companies)
    {
        $companies = $companies ? explode(",", $companies) : null;
        if ($companies)
            return $query->whereIn('company_id', $companies);
        return $query;
    }

    public function scopeStatusIn($query, $status)
    {
        if ($status) {
            $status = explode(",", $status);
            return $query->whereIn('status', $status);
        }
        return $query;
    }

    public function scopeOrderByColumn($query, $column = null, $direction = 'DESC')
    {
        $self_columns = [...$this->fillable];
        if ($column && $direction && in_array($column, $self_columns)) {
            return $query->orderBy("company_user.$column", $direction)
                ->orderBy('company_user.created_at', $direction)
                ->orderBy('company_user.id', $direction);
        }

        if ($column == 'company') {
            return $query
                ->addJoins('companies')
                ->orderBy('companies.name', $direction)
                ->orderBy('company_user.created_at', $direction)
                ->orderBy('company_user.id', $direction);
        }

        if ($column == 'first_name' || $column == 'last_name' || $column == 'email') {
            return $query
                ->addJoins('mobile_app_users')
                ->orderBy("mobile_app_users.$column", $direction)
                ->orderBy('company_user.created_at', $direction)
                ->orderBy('company_user.id', $direction);

        }

        return $query->orderBy('company_user.created_at', 'desc')->orderBy('company_user.id', 'desc');
    }

    public function scopeAddJoins($q, $join_name = null)
    {
        if ($join_name == 'companies') {
            return $q->join('companies', 'company_user.company_id', '=', 'companies.id');
        };

        if ($join_name == 'mobile_app_users') {
            return $q->join('mobile_app_users', 'company_user.mobile_app_user_id', '=', 'mobile_app_users.id');
        };

        return $q->join('companies', 'company_user.company_id', '=', 'companies.id')->join('mobile_app_users', 'company_user.mobile_app_user_id', '=', 'mobile_app_users.id');
    }
}
