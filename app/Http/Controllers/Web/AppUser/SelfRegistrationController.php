<?php

namespace App\Http\Controllers\Web\AppUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileAppUser\ConfirmRegistraionRequest;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\MobileAppUser;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SelfRegistrationController extends Controller
{
    public function show(Request $request, MobileAppUser $appuser)
    {
        $company = Company::findOrFail($request->company_id);
        // $companies_count = $appuser->companies()->whereIn('status', [CompanyUser::STATUS_ACTIVE, CompanyUser::STATUS_INACTIVE])->count();

        $company_user = CompanyUser::query()
            ->where('company_id', $request->company_id)
            ->where('mobile_app_user_id', $appuser->id)
            ->whereIn('status', [CompanyUser::STATUS_ACTIVE, CompanyUser::STATUS_INACTIVE])
            ->first();

        if ($company_user) {
            // $appuser->companies()->where('company_id', $company->id)->where('status', CompanyUser::STATUS_PENDING)->update([
            //     'status' => CompanyUser::STATUS_ACTIVE
            // ]);
            $company_user->update([
                'status' => CompanyUser::STATUS_ACTIVE
            ]);
            return Inertia::render('AppUsers/RegistrationSuccess');
        }

        return Inertia::render('AppUsers/Register', [
            'appuser' => $appuser,
            'company' => $company,
            'language_code' => $request->language_code
        ]);
    }

    public function register(ConfirmRegistraionRequest $request, MobileAppUser $appuser)
    {
        $input = $request->only('first_name', 'last_name', 'country_iso_code', 'phone_number', 'tos', 'password', 'language_id', 'company');
        $input['country'] = $request->country_iso_code;
        $input['password'] = bcrypt($input['password']);
        $appuser->update($input);
        CompanyUser::where('mobile_app_user_id', $appuser->id)->update(['status' => CompanyUser::STATUS_ACTIVE]);
        return Inertia::render('AppUsers/RegistrationSuccess');
    }
}
