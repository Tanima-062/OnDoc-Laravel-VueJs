<?php
namespace App\Traits;

use App\Contracts\CompanyWisePrefixIDContract;

trait CompanyWisePrefixID{
    public static function boot(){
        parent::boot();

        static::creating(function($model){
            if($model instanceof CompanyWisePrefixIDContract){
                $model->prefix_id = self::generatePrefixId($model);
            }
        });
    }


    /**
     * Generate prefix_id by company
     *
     * @param App\Model $model
     * @return string
     */
    protected static function generatePrefixId($model): string{
        $last_id = 1;

        if($last_supplier = self::where('company_id', $model->company_id)->orderBy('prefix_id', 'DESC')->first()){
            sscanf($last_supplier->prefix_id, self::getPrefix()."%05d", $num);
           if($num){
                $last_id = $num + 1;
           }
        }

        return sprintf("%s%05d", self::getPrefix(), $last_id);
    }


     /**
     * Generate prefix_id by company
     *
     * @param App\Model $model
     * @return string
     */
    protected static function generatePrefixIdByCompanyId(int $company_id): string{
        $last_id = 1;

        if($last_supplier = self::where('company_id', $company_id)->orderBy('prefix_id', 'DESC')->first()){
            sscanf($last_supplier->prefix_id, self::getPrefix()."%05d", $num);
           if($num){
                $last_id = $num + 1;
           }
        }

        return sprintf("%s%05d", self::getPrefix(), $last_id);
    }
}
