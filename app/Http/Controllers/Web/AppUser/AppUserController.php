<?php

namespace App\Http\Controllers\Web\AppUser;

use Inertia\Inertia;
use App\Models\Company;
use App\Models\CompanyUser;
use Illuminate\Http\Request;
use App\Models\MobileAppUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppUserRegistrationInvitationMail;
use App\Http\Requests\MobileAppUser\StoreRequest;
use App\Http\Resources\MobileAppUser\AppUserResoruce;
use App\Mail\AppUserPermitionInvitationMail;
use App\Models\Language;

class AppUserController extends Controller
{
    public function index(Request $request)
    {
        $user_company_id = auth()->user()->company_id;

        $appusers = CompanyUser::with(['user'])
            ->withWhereHas('company', fn ($q) => $q->when($user_company_id, fn ($q) => $q->where('companies.id', $user_company_id)))
            ->companyIn($request->company)
            ->statusIn($request->status)
            ->orderByColumn($request->order_by, $request->direction)
            ->select('company_user.*')
            ->paginate($request->per_page)
            ->withQueryString()
            ->onEachSide(1);
        $appusers->getCollection()->transform(fn ($item) => new AppUserResoruce($item));
        return Inertia::render('AppUsers/Index', ['appusers' =>  $appusers]);
    }

    public function show()
    {
        return Inertia::render('AppUsers/Create');
    }

    public function create()
    {
        $languages = Language::select('id as value', 'name as label')->get();
        return Inertia::render('AppUsers/Create', ['languages' => $languages]);
    }

    public function store(StoreRequest $request)
    {
        $input = $request->only('first_name', 'last_name', 'language_id');

        $company = Company::where('id',  auth()->user()->company_id)->firstOrFail();
        $user = MobileAppUser::firstOrCreate(['email' => $request->email], $input);

        $status = $user->password ? CompanyUser::STATUS_ACTIVE : CompanyUser::STATUS_PENDING;
        $company->mobileAppusers()->sync([$user->id => ['status' => $status]], false);

        $code = $user->language->code;
        $url = route('appusers.register', ['appuser' => $user->id, 'company_id'  => $company->id, 'language_code' => $code]);

        if ($user->companies->count() > 1) {
            Mail::to($user->email)->send(new AppUserPermitionInvitationMail($user, $company, $code));
        } else {
            Mail::to($user->email)->send(new AppUserRegistrationInvitationMail($url, $user, $company, $code));
        }

        $message = trans("Invitation to app user “{$user->name}” was successfully sent");
        return redirect(route('appusers.index'))->with('message', $message);
    }


    public function edit()
    {
        return Inertia::render('AppUsers/Create');
    }

    public function update()
    {
        return Inertia::render('AppUsers/Create');
    }

    public function destroy(CompanyUser $appuser)
    {
        $mobileAppUser = $appuser->user;

        $appuser->delete();
        return redirect()->back()->with('message', [
            'text' => "App User “:name” was successfully deleted",
            'attributes' => [
                'name' => $mobileAppUser->name,
            ]
        ]);
    }

    public function updateStatus(Request $request, CompanyUser $appuser)
    {
        $request->validate(['status' => 'in:active,inactive']);
        $appuser->update(
            ['status' => $request->status],
        );

        $statusText = $request->status == 'inactive' ? 'Deactivated' : 'Activated';
        $message = trans("App User “:name” was successfully $statusText", ['name' => $appuser->user->name]);
        return redirect()->back()->with('message', $message);
    }

    public function getFilterData(Request $request)
    {
        $column = $request->column;
        $user_company_id = auth()->user()->company_id;

        $query = CompanyUser::whereHas('company', fn ($q) => $q->when($user_company_id, fn ($q) => $q->where('companies.id', $user_company_id)))
            ->companyIn($request->company)
            ->statusIn($request->status)
            ->orderByColumn($request->order_by, $request->direction);

        if ($column == 'status') {
            $status = $query->pluck('status')->unique()->values()->map(function ($status) {
                if ($status) {
                    return ['label' => ucfirst($status), 'value' => $status];
                }
            });
            return $status;
        }

        if ($column == 'company') {
            return $query->join('companies as company', 'company_user.company_id', '=', 'company.id')->select('company.name as label', 'company.id as value')->get()->unique('value')->values();
        }

        return [];
    }
}
