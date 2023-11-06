<?php


namespace App\Traits;

use App\Models\CompanySubAdmin;
use App\Models\User;

trait HasPermission
{

    protected $permissions = array(
        'system_admin' => array(
            'companies.view',
            'companies.edit',

            'company_admin.view',
            'company_admin.edit',

            'categories.view',
            'suppliers.view',
            'products.view',
            'mobile_app_users.view',
        ),

        'company_admin' => array(
            'categories.view',
            'categories.edit',
            'suppliers.view',
            'suppliers.edit',
            'products.view',
            'products.edit',
            'sub_admins.view',
            'sub_admins.edit',
            'mobile_app_users.create',
            'mobile_app_users.view',
            'mobile_app_users.edit',
        ),
        'company_sub_admin' => array(
            'categories.view',
            'suppliers.view',
            'products.view',
            'mobile_app_users.view',
        ),
    );

    public function getAllPermissions()
    {
        $user = auth()->user();

        if($user->type == User::COMPANY_SUB_ADMIN){
            if($user->permission == 'full'){
                $this->permissions['company_sub_admin'] = [
                    'categories.view',
                    'categories.edit',
                    'suppliers.view',
                    'suppliers.edit',
                    'products.view',
                    'products.edit',
                    'mobile_app_users.view',
                    'mobile_app_users.edit',
                ];
            }
        }

        return $this->permissions[auth()->user()->type];
    }

    public function canAccess($permission, $arguments = [])
    {
        return in_array($permission, $this->permissions[auth()->user()->type]);
        //return false;
    }
}
