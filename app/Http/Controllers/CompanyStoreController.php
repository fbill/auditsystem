<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CompanyStoreRepo;

class CompanyStoreController extends Controller
{

    protected $companyStoreRepo;

    public function __construct(CompanyStoreRepo $companyStoreRepo)
    {
        // set the model
        //$this->model = new Repository($company);
        $this->companyStoreRepo = $companyStoreRepo;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return $this->companyRepo->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getGraphStores($company_id)
    {
        $values=$this->companyStoreRepo->getGraphStores($company_id);
        return $values;
    }

    public function getUbigeosForCampaigne($company_id)
    {
        $values=$this->companyStoreRepo->getUbigeosForCampaigne($company_id);
        return $values;
    }

    public function getBaseForCompanyUbigeoAudit(Request $request)
    {
        $valoresPost= $request->all();//dd($valoresPost);
        $company_id = $valoresPost['company_id'];
        $ubigeo = $valoresPost['ubigeo'];
        $audt_id = $valoresPost['audit_id'];
        $values=$this->companyStoreRepo->getBaseForCompanyUbigeoAudit($company_id,$audt_id,$ubigeo);
        return $values;
    }

}
