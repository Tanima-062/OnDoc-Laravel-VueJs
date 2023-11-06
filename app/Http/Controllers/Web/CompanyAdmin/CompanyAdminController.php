<?php

namespace App\Http\Controllers\Web\CompanyAdmin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Company;
use App\Models\Language;
use App\Models\CompanyAdmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyAdmin\CreateCompanyAdminRequest;
use App\Http\Requests\CompanyAdmin\UpdateCompanyAdminRequest;
use App\Notifications\CompanyAdmin\CompanyAdminInvitationNotification;
use Illuminate\Support\Facades\DB;
class CompanyAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request  )
    {
        $this->authorize('viewAny', User::class);

        $start_date = $request->get('start_date', null);
        $end_date = $request->get('end_date', null);

        $company_admins = User::query()
            ->where('type', '!=', User::SYSTEM_ADMIN)
            ->with('company:id,name')
            ->withCount(['documents'])
            ->where(function ($q) use ($start_date, $end_date) {
                if (!is_null($start_date) && !is_null($end_date)) {
                    $q->whereBetween(DB::raw('date_format(created_at, \'%Y-%m-%d\')'), [$start_date, $end_date]);
                }
            })
            ->userTypeIn($request->user_type)
            ->companyIn($request->company)
            ->statusIn($request->status)
            ->when(in_array(request('order_by'), ['created_at', 'prefix_id', 'first_name', 'type', 'status','documents_count' ]),
                fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC'))
            )
            ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
                fn($q)=>$q->orderBy(Company::select('name')->whereColumn('users.company_id', 'companies.id'), request('direction', 'DESC')),
            )
            ->when(!request('order_by'), fn($q)=> $q->orderBy('id', 'DESC'))
            ->paginate(request('per_page', 15))
            ->withQueryString()
            ->onEachSide(1);

        return Inertia::render('CompanyAdmins/Index',[
            'company_admins' =>  $company_admins
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
        return Inertia::render('CompanyAdmins/Create', [
            'prefix_id'     =>   User::getPrefixIdByCompany(User::COMPANY_ADMIN, auth()->user()),
            'companies'     =>  Company::all(['id as value', 'name as label']),
            'languages'     =>  $languages
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCompanyAdminRequest $request)
    {
        $password = uniqid();

        $user = User::create($request->only('first_name', 'last_name', 'email', 'company_id', 'language_id')+ [
            'status'        =>  User::STATUS_ACTIVE,
            'type'          =>  User::COMPANY_ADMIN,
            'password'      =>  bcrypt($password)
        ]);

        $user->refresh();

        $user->notify(new CompanyAdminInvitationNotification($user, $user->company, $password, $user->language->code));

        return redirect(route('company-admins.index')) ->with('message', [
            'text' => "Admin “:name” was successfully updated",
            'attributes' => [
                'name' => $user->name,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyAdmin  $companyAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(User $companyAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyAdmin  $companyAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(User $companyAdmin)
    {
        $this->authorize('update', $companyAdmin);
        $languages = Language::select('id as value', 'name as label')->get();

        return Inertia::render('CompanyAdmins/Edit', [
            'company_admin'  =>  $companyAdmin,
            'companies'     =>  Company::all(['id as value', 'name as label']),
            'languages'     =>  $languages
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyAdmin  $companyAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyAdminRequest $request, User $companyAdmin)
    {
        // $companyAdmin->update($request->only('permission', 'first_name', 'last_name', 'email'));
        $companyAdmin->update($request->only('permission', 'first_name', 'last_name', 'language_id'));

        return redirect(route('company-admins.index')) ->with('message', [
            'text' => "Sub admin “:name” was successfully updated",
            'attributes' => [
                'name' => $companyAdmin->name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyAdmin  $companyAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $companyAdmin)
    {
        //
    }


    public function toggleStatus(Request $request, User $companyAdmin)
    {
        // $this->authorize('update', $companyAdmin);

        $request->validate(['status' => 'in:active,inactive']);

        $companyAdmin->update(
            ['status' => $request->status],
        );

        $statusText = $request->status == 'inactive' ? 'Deactivated' : 'Activated';
        $message = trans("Admin “:name” was successfully $statusText", ['name' => $companyAdmin->name]);

        return redirect()->back()->with('message', $message);
    }

    public function getFilterData(Request $request)
    {
        $column = $request->column;
        $start_date = $request->get('start_date', null);
        $end_date = $request->get('end_date', null);

        $query = User::query()
        ->where('type', '!=', User::SYSTEM_ADMIN)
        ->with('company:id,name')
        ->withCount(['documents'])
        ->where(function ($q) use ($start_date, $end_date) {
            if (!is_null($start_date) && !is_null($end_date)) {
                $q->whereBetween(DB::raw('date_format(created_at, \'%Y-%m-%d\')'), [$start_date, $end_date]);
            }
        })
        ->userTypeIn($request->user_type)
        ->companyIn($request->company)
        ->statusIn($request->status)
        ->when(in_array(request('order_by'), ['created_at', 'prefix_id', 'first_name', 'type', 'status','documents_count' ]),
            fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC'))
        )
        ->when((request('order_by')  == 'company' && auth()->user()->type == User::SYSTEM_ADMIN),
            fn($q)=>$q->orderBy(Company::select('name')->whereColumn('users.company_id', 'companies.id'), request('direction', 'DESC')),
        )
        ->when(!request('order_by'), fn($q)=> $q->orderBy('id', 'DESC'));

        if ($column == 'status') {
            $status = $query->pluck('status')->unique()->values()->map(function ($status) {
                if ($status) {
                    return ['label' => ucfirst($status), 'value' => $status];
                }
            });
            return $status;
        }

        if ($column == 'company') {
            $ids = $query->whereNotNull('company_id')->pluck('company_id')->unique()->values()->toArray();
            return Company::select('id as value', 'name as label')->whereIn('id', $ids)->orderByRaw("FIELD(id," . implode(", ", $ids) . ")")->get();

        }

        if($column == 'user_type'){
            $type = $query->whereNotNull('type')->pluck('type')->unique()->values()->map(function ($type) {
                if ($type) {
                    return ['label' => ucfirst(str_replace('_', ' ',$type)), 'value' => $type];
                }
            });
            return $type;
        }

        return [];
    }
}
