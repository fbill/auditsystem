<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PollRepo;
use App\Repositories\CompanyRepo;
use App\Repositories\PollDetailRepo;
use App\Repositories\PollOptionDetailRepo;

class PollController extends Controller
{
    protected $pollRepo;
    protected $companyRepo;
    protected $pollDetailRepo;
    protected $pollOptionDetailRepo;

    public function __construct(PollOptionDetailRepo $pollOptionDetailRepo,PollDetailRepo $pollDetailRepo,PollRepo $pollRepo,CompanyRepo $companyRepo)
    {
        // set the model
        //$this->model = new Repository($company);
        $this->pollRepo = $pollRepo;
        $this->companyRepo = $companyRepo;
        $this->pollDetailRepo = $pollDetailRepo;
        $this->pollOptionDetailRepo = $pollOptionDetailRepo;
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

    public function getCategoryForCompanyAudit($company_id,$company_audit_id)
    {
        return $this->pollRepo->categoriesPollForCompanyAudit($company_id,$company_audit_id);
    }

    public function getPollsForCategory($category_id,$company_audit_id)
    {
        return $this->pollRepo->getPollsForCategory($category_id,$company_audit_id);
    }

    public function getQuestionForSod(Request $request)
    {
        $customer_id = 4;
        $estudio=6;
        $valoresPost= $request->all();//dd($valoresPost);
        $company_id = $valoresPost['company_id'];
        $store_id = $valoresPost['store_id'];
        $publicity_id = $valoresPost['publicity_id'];

        $indicador[] = "existeVent";
        $indicador[] = "visibleVent";
        $indicador[] = "ventanaW";
        $indicador[] = "comoEstaVent";

        $pollsWeb =$this->getAllPollsWeb($this->companyRepo,$this->pollRepo, $customer_id,$estudio);

        foreach ($pollsWeb as $pollWeb) {
            if (($pollWeb['identificador']==$indicador[0]) and ($pollWeb['company_id']==$company_id))
            {
                $pollExisteVent = $pollWeb['poll_id'];
            }
            if (($pollWeb['identificador']==$indicador[1]) and ($pollWeb['company_id']==$company_id))
            {
                $pollVisibleVent = $pollWeb['poll_id'];
            }
            if (($pollWeb['identificador']==$indicador[2]) and ($pollWeb['company_id']==$company_id))
            {
                $pollVentanaW = $pollWeb['poll_id'];
            }
            if (($pollWeb['identificador']==$indicador[3]) and ($pollWeb['company_id']==$company_id))
            {
                $pollComoEstaVent = $pollWeb['poll_id'];
            }
        }

        $pollDetailRepo = $this->pollDetailRepo;
        $pollOptionDetailRepo = $this->pollOptionDetailRepo;
        $storeExiste = $pollExisteVent;
        $existeVent = $this->getResponsePolls($pollDetailRepo,$pollOptionDetailRepo,$store_id,$company_id,$publicity_id,$storeExiste,'YesNo');


        $storeVisible = $pollVisibleVent;
        $visibleVent = $this->getResponsePolls($store_id,$company_id,$publicity_id,$storeVisible,'YesNo');


        $storeW = $pollVentanaW;
        $ventW = $this->getResponsePolls($store_id,$company_id,$publicity_id,$storeW,'YesNo');


        $poll_comoEstaVent = $pollComoEstaVent;
        $comoEstaVent = $this->getResponsePolls($store_id,$company_id,$publicity_id,$poll_comoEstaVent,'Option');

        $pollsResult = array('existe' => $existeVent,'visible' => $visibleVent,'trabajada' => $ventW,'comoEstaVent'=>$comoEstaVent);
        return $pollsResult;
    }
}
