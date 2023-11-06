<?php

namespace App\Http\Controllers\Web\CompanySubAdmin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanySubAdmin\CreateCompanySubAdminRequest;
use App\Http\Requests\CompanySubAdmin\UpdateCompanySubAdminRequest;
use App\Notifications\CompanySubAdmin\CompanySubAdminInvitationNotification;

class CompanySubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $company_sub_admins = User::query()
            ->where('type', User::COMPANY_SUB_ADMIN)
            ->when(auth()->user()->type != User::SYSTEM_ADMIN,
                fn($q)=> $q->where('company_id', auth()->user()->company_id),
                fn($q)=> $q->with('company:id,name')
            )
            ->when(request('status') && !is_null(request('status')), function($q){
                $status = explode(',', request()->status);
                $q->whereIn('status', $status);
            })
            ->when(request('permission') && !is_null(request('permission')), function($q){
                $permission = explode(',', request()->permission);
                $q->whereIn('permission', $permission);
            })
            ->when(in_array(request('order_by'), ['prefix_id', 'permission', 'first_name', 'last_name', 'status']),
                fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC'))
            )
            ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
                fn($q)=>$q->orderBy(Company::select('name')->whereColumn('company_sub_admins.company_id', 'companies.id'), request('direction', 'DESC')),
            )
            ->when(!request('order_by'), fn($q)=> $q->orderBy('prefix_id', 'DESC'))
            ->paginate(request('per_page', 15))
            ->withQueryString()
        ;

        return Inertia::render('CompanySubAdmins/Index', [
            'company_sub_admins'    =>  $company_sub_admins
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $languages = Language::select('id as value', 'name as label')->get();

        // dd(User::getPrefixIdByCompany(User::COMPANY_SUB_ADMIN, auth()->user()));

        return Inertia::render('CompanySubAdmins/Create', [
            'prefix_id'     =>   User::getPrefixIdByCompany(User::COMPANY_SUB_ADMIN, auth()->user()),
            'languages'     =>  $languages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompanySubAdminRequest $request)
    {
        $password = uniqid();

        $user = User::create($request->only('first_name', 'last_name', 'email', 'permission', 'language_id')+ [
            'status'        =>  User::STATUS_ACTIVE,
            'company_id'    =>  auth()->user()->company_id,
            'password'      =>  bcrypt($password),
            'type'          =>  User::COMPANY_SUB_ADMIN,
        ]);

        $user->refresh();

        $user->notify(new CompanySubAdminInvitationNotification($user, $user->company, $password, $user->language->code));

        return redirect(route('company-sub-admins.index')) ->with('message', [
            'text' => "Sub admin “:name” was successfully created",
            'attributes' => [
                'name' => $user->name,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanySubAdmin  $companySubAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanySubAdmin  $companySubAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(User $companySubAdmin)
    {
        $this->authorize('update', $companySubAdmin);
        $languages = Language::select('id as value', 'name as label')->get();
        return Inertia::render('CompanySubAdmins/Edit', [
            'company_sub_admin'  =>  $companySubAdmin,
            'languages'     =>  $languages
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanySubAdmin  $companySubAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanySubAdminRequest $request, User $companySubAdmin)
    {
        // $companySubAdmin->update($request->only('permission', 'first_name', 'last_name', 'email'));
        $companySubAdmin->update($request->only('permission', 'first_name', 'last_name', 'language_id'));

        return redirect(route('company-sub-admins.index')) ->with('message', [
            'text' => "Sub admin “:name” was successfully updated",
            'attributes' => [
                'name' => $companySubAdmin->name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanySubAdmin  $companySubAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $companySubAdmin)
    {
        //
    }


    public function toggleStatus(Request $request, User $CompanySubAdmin)
    {
        // $this->authorize('update', $CompanySubAdmin);

        $request->validate(['status' => 'in:active,inactive']);

        $CompanySubAdmin->update(
            ['status' => $request->status],
        );

        $statusText = $request->status == 'inactive' ? 'Deactivated' : 'Activated';
        $message = trans("Sub Admin “:name” was successfully $statusText", ['name' => $CompanySubAdmin->name]);

        return redirect()->back()->with('message', $message);
    }

    public function getFilterData(Request $request)
    {
        $column = $request->column;

        $query = User::query()
            ->where('type', User::COMPANY_SUB_ADMIN)
            ->when(auth()->user()->type != User::SYSTEM_ADMIN,
                fn($q)=> $q->where('company_id', auth()->user()->company_id),
                fn($q)=> $q->with('company:id,name')
            )
            ->when(request('status') && !is_null(request('status')), function($q){
                $status = explode(',', request()->status);
                $q->whereIn('status', $status);
            })
            ->when(request('permission') && !is_null(request('permission')), function($q){
                $permission = explode(',', request()->permission);
                $q->whereIn('permission', $permission);
            })
            ->statusIn($request->status)
            ->when(in_array(request('order_by'), ['prefix_id', 'permission', 'first_name', 'last_name', 'status']),
                fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC'))
            )
            ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
                fn($q)=>$q->orderBy(Company::select('name')->whereColumn('company_sub_admins.company_id', 'companies.id'), request('direction', 'DESC')),
            )
            ->when(!request('order_by'), fn($q)=> $q->orderBy('prefix_id', 'DESC'));

        if ($column == 'status') {
            $status = $query->pluck('status')->unique()->values()->map(function ($status) {
                if ($status) {
                    return ['label' => ucfirst($status), 'value' => $status];
                }
            });
            return $status;
        }
        else if ($column == 'permission') {
            $permission = $query->pluck('permission')->unique()->values()->map(function ($permission) {
               return [
                   'value'  => $permission,
                   'label'  => $permission == 'view' ? 'User Management': 'Full Permission',
               ];
            });
            return $permission;
        }
        return [];
    }
}
