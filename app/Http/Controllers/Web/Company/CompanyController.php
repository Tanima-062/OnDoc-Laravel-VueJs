<?php

namespace App\Http\Controllers\Web\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Document;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    use UploadAble;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start_date = $request->get('start_date', null);
        $end_date = $request->get('end_date', null);

        $query = Company::query()
                    ->where(function ($q) use ($start_date, $end_date) {
                        if (!is_null($start_date) && !is_null($end_date)) {
                            $q->whereBetween(DB::raw('date_format(created_at, \'%Y-%m-%d\')'), [$start_date, $end_date]);
                        }
                    })
                    ->statusIn($request->status);


        $mobileAppuserQuery = clone $query;
        $mobile_app_users = $mobileAppuserQuery->select('id')->withCount('mobileAppUsers')->get();

        $mobile_app_users_min_value = $mobile_app_users->min('mobile_app_users_count');
        $mobile_app_users_max_value = $mobile_app_users->max('mobile_app_users_count');


        $start_value = $request->get('mobile_app_user_start_value', $mobile_app_users_min_value) ?? 0;
        $end_value = $request->get('mobile_app_user_end_value', $mobile_app_users_max_value) ?? 0;

        if($end_value > 0){

            $query->has('mobileAppUsers','>=', $start_value)
                ->has('mobileAppUsers', '<=', $end_value)
                ->withCount('mobileAppUsers');
        }else{
            $query->withCount('mobileAppUsers');
        }

        $documentQuery = clone $query;
        $documents = $documentQuery->select('id')->withCount('documents')->get();

        $documents_min_value = $documents->min('documents_count');
        $documents_max_value = $documents->max('documents_count');

        $start_value = $request->get('document_start_value', $documents_min_value) ?? 0;
        $end_value = $request->get('document_end_value', $documents_max_value) ?? 0;

        if($end_value > 0){

            $query->has('documents','>=', $start_value)
                ->has('documents', '<=', $end_value)
                ->withCount('documents');
        }else{
            $query->withCount('documents');
        }

        $companies = $query->when(in_array(request('order_by'), ['created_at','name', 'prefix_id', 'mobile_app_users_count', 'documents_count', 'status']),
                        fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC')),
                        fn($q)=>$q->orderBy('id', request('direction', 'DESC')),
                    )
                    ->paginate(request('per_page', 15))
                    ->withQueryString()
                    ->onEachSide(1);

        return Inertia::render('Companies/Index',[
            'companies' =>  $companies,
            'documents_min_value' => $documents_min_value,
            'documents_max_value' => $documents_max_value,
            'mobile_app_users_min_value' => $mobile_app_users_min_value,
            'mobile_app_users_max_value' => $mobile_app_users_max_value
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Companies/Create', [
            // 'prefix_id'     =>  Supplier::generatePrefixIdByCompanyId(auth()->user()->company_id)
            'prefix_id'     =>  nextId('companies', Company::PREFIX)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyCreateRequest $request)
    {
        $data = $request->except('prefix_id', 'logo', 'status', );
        if($request->hasFile('logo')){
            $data['logo']   = $this->uploadOne($request->logo, 'company', getDisk());
        }

        $company = Company::create($data);

        return redirect(route('companies.index')) ->with('message', [
            'text' => "Company “:name” was successfully created",
            'attributes' => [
                'name' => $company->name,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return Inertia::render('Companies/Edit', [
            'company'       =>  $company->append('logo_url')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $data = $request->except('prefix_id', 'logo', 'status', );
        if($request->hasFile('logo')){
            $data['logo']   = $this->uploadOne($request->logo, 'company', getDisk());

            $this->deleteOne($company->logo, getDisk());
        }

        $company->update($data);

        return redirect(route('companies.index')) ->with('message', [
            'text' => "Company “:name” was successfully updated",
            'attributes' => [
                'name' => $company->name,
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    public function updateStatus(Request $request, Company $company)
    {
        $request->validate(['status' => 'in:active,inactive']);
        $company->update(
            ['status' => $request->status],
        );
        $statusText = $request->status == 'inactive' ? 'Deactivated' : 'Activated';
        $message = trans("Company “:name” has $statusText", ['name' => $company->name]);
        return redirect()->back()->with('message', $message);
    }

    public function getFilterData(Request $request)
    {
        $start_date = $request->get('start_date', null);
        $end_date = $request->get('end_date', null);

        $query = Company::query()
                    ->withCount(['documents', 'mobileAppUsers'])
                    ->where(function ($q) use ($start_date, $end_date) {
                        if (!is_null($start_date) && !is_null($end_date)) {
                            $q->whereBetween(DB::raw('date_format(created_at, \'%Y-%m-%d\')'), [$start_date, $end_date]);
                        }
                    })
                    ->statusIn($request->status);

        $mobileAppuserQuery = clone $query;
        $mobile_app_users = $mobileAppuserQuery->select('id')->withCount('mobileAppUsers')->get();

        $mobile_app_users_min_value = $mobile_app_users->min('mobile_app_users_count');
        $mobile_app_users_max_value = $mobile_app_users->max('mobile_app_users_count');


        $start_value = $request->get('mobile_app_user_start_value', $mobile_app_users_min_value) ?? 0;
        $end_value = $request->get('mobile_app_user_end_value', $mobile_app_users_max_value) ?? 0;

        if($end_value > 0){

            $query->has('mobileAppUsers','>=', $start_value)
                ->has('mobileAppUsers', '<=', $end_value)
                ->withCount('mobileAppUsers');
        }else{
            $query->withCount('mobileAppUsers');
        }

        $documentQuery = clone $query;
        $documents = $documentQuery->select('id')->withCount('documents')->get();

        $documents_min_value = $documents->min('documents_count');
        $documents_max_value = $documents->max('documents_count');

        $start_value = $request->get('document_start_value', $documents_min_value) ?? 0;
        $end_value = $request->get('document_end_value', $documents_max_value) ?? 0;

        if($end_value > 0){

            $query->has('documents','>=', $start_value)
                ->has('documents', '<=', $end_value)
                ->withCount('documents');
        }else{
            $query->withCount('documents');
        }

        $query->when(in_array(request('order_by'), ['created_at','name', 'prefix_id', 'mobileAppUsers_count', 'documents_count', 'status']),
            fn($q)=>$q->orderBy(request('order_by'), request('direction', 'DESC')),
        );

        if ($request->column == 'status') {
            $status = $query->pluck('status')->unique()->values()->map(function ($status) {
                if ($status) {
                    return ['label' => ucfirst($status), 'value' => $status];
                }
            });
            return $status;
        }

        return [];
    }


    /**
     * Delete company logo
     *
     * @param Company $company
     * @return void
     */
    public function deleteLogo(Company $company)
    {
        $this->deleteOne($company->logo, getDisk());
        $company->update(['logo'=>null]);

        return response(['status'=>true]);
    }
}
