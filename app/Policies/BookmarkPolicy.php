<?php

namespace App\Policies;

use App\Models\Bookmark;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Document;
use App\Models\MobileAppUser;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookmarkPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function bookmark(MobileAppUser $user, $bookmarkable_id, $bookmarkable_type)
    {
        try {
            $product = Product::where('id', $bookmarkable_type == 'product' ? $bookmarkable_id : Document::findOrFail($bookmarkable_id)->product_id)->firstOrFail();

            if($product->status == Product::INACTIVE)
                throw new NotFoundHttpException("This product is inactive");

            //authorize if public access available
            if($product->public_access)
                return true;

            //authorize if user is invited in the company
            return CompanyUser::where('company_id', $product->company_id)->where('mobile_app_user_id', $user->id)->where('status', CompanyUser::STATUS_ACTIVE)->exists();

        } catch (\Throwable $th) {
            if($th instanceof ModelNotFoundException) {
                throw new NotFoundHttpException("The resource was not found");
            }
            throw $th;
        }
    }

    public function view(MobileAppuser $user, Bookmark $bookmark)
    {
        $product = Product::where('status', Product::ACTIVE)->where('id', $bookmark->bookmarkable_type == 'App\Models\Document' ? Document::findOrFail($bookmark->bookmarkable_id)->product_id : $bookmark->bookmarkable_id)->firstOrFail();
        $company_permission = CompanyUser::where('company_id', $product->company_id)->where('mobile_app_user_id', $user->id)->where('status', CompanyUser::STATUS_ACTIVE)->exists();
        return $bookmark->mobile_app_user_id == $user->id && ($company_permission || $product->public_access);
    }
}
