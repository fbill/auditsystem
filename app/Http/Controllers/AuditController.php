<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuditRepo;

class AuditController extends Controller
{
    protected $auditRepo;

    public function __construct(AuditRepo $auditRepo)
    {
        // set the model
        //$this->model = new Repository($company);
        $this->auditRepo = $auditRepo;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function getAuditsForCompany($company_id)
    {
        return $this->auditRepo->getAuditsForCompanyId($company_id);
    }

    public function getMenusForCompany($study_id,$company_id="0")
    {
        if ($company_id=="0")
        {
            $audits = $this->auditRepo->getAuditsForCompanyId($company_id);
            $structMenu = $this->getMenus($audits);
        }else{
            switch ($study_id) {
                case 17:
                    $structMenu[] = array('name'=>'Panel de Control','icon'=>'icon-speedometer');
                    $structMenu[] = array('title'=>true,'name'=>'Auditorias');
                    $structMenu[] = array('id'=>1,'name'=>'Home','url'=>'/panel','icon'=>'icon-drop');
                    break;
                default:
                    $structMenu=[];
                    break;
            }
        }

        return $structMenu;
    }
}
