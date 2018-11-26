<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Repositories\PublicityRepo;
use App\Repositories\PollRepo;

class PublicityController extends Controller
{
    protected $publicityRepo;
    protected $pollRepo;

    public function __construct(PollRepo $pollRepo,PublicityRepo $publicityRepo)
    {
        // set the model
        //$this->model = new Repository($company);
        $this->publicityRepo = $publicityRepo;
        $this->pollRepo = $pollRepo;

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


    public function getPublicitiesForCategory($category_id,$company_id)
    {
        $publicities = $this->publicityRepo->getPublicitiesForCategory($category_id,$company_id);

        return $publicities;
    }

    public function ListStoresPublicity(Request $request)
    {
        $valoresPost= $request->all();//dd($valoresPost);
        $company_id = $valoresPost['company_id'];
        $trabajada = $valoresPost['trabajada'];
        if ($valoresPost['ciudad']<>"0"){
            $city =$valoresPost['ciudad'];
        }else{
            $city ="0";
        }
        if ($valoresPost['auditor']<>"0"){
            $auditor =$valoresPost['auditor'];
        }else{
            $auditor ="0";
        }
        if ($valoresPost['publicity']<>"0"){
            $publicity_id =$valoresPost['publicity'];
        }else{
            $publicity_id ="0";
        }
        if ($valoresPost['tipo']<>"0"){
            $tipo =$valoresPost['tipo'];
        }else{
            $tipo ="0";
        }
        $storesxCampaigne1 = $this->publicityRepo->getPublicityAlicorp($city,$auditor,$publicity_id,$company_id);
        $objPolls = $this->pollRepo->getQuestionForWeb($company_id);
        foreach ($objPolls as $objPoll) {
            if (($objPoll['identificador']=='abierto') and ($objPoll['company_id']==$company_id))
            {
                $valoresCampaigne[$company_id]['abierto'] = $objPoll['poll_id'];
            }
            if (($objPoll['identificador']=='permitio') and ($objPoll['company_id']==$company_id))
            {
                $valoresCampaigne[$company_id]['permitio'] = $objPoll['poll_id'];
            }
            if (($objPoll['identificador']=='existeVent') and ($objPoll['company_id']==$company_id))
            {
                $valoresCampaigne[$company_id]['existeVent'] = $objPoll['poll_id'];
            }
            if (($objPoll['identificador']=='ventanaW') and ($objPoll['company_id']==$company_id))
            {
                $valoresCampaigne[$company_id]['ventanaW'] = $objPoll['poll_id'];
            }
        }
        if ($tipo=="Sod"){
            if (count($storesxCampaigne1)>0)
            {
                $collectStores = Collection::make($storesxCampaigne1);
                $grouped = $collectStores->groupBy('store_id');//dd($grouped[196514]);
                foreach ($grouped as $index =>$store)
                {
                    $storeAbierto="Si";$permitio="Si";$existeVent="Si";$ventW="Si";
                    //$store agrupa u array de objetos por cada poll_details_id
                    //if ($store->result == null){$result = 0;}else{$result = 1;}
                    //$publicty_detail_id = $store->publicity_details_id;$sod = $store->sod;
                    $collectPolls = Collection::make($store);
                    $grouped1 = $collectPolls->groupBy('poll_id');dd($grouped1);
                    //$grouped2 = $grouped1->where('')
                    foreach ($grouped1 as $index1 =>$store1)
                    {
                        if ($index1==$valoresCampaigne[$company_id]['abierto']){
                            if (($store1[0]->result==1) and ($store1[0]->publicity_id==0))
                            {
                                $storeAbierto= "Si";
                            }else{
                                $storeAbierto= "No";
                            }

                        }else{
                            if ($index1==$valoresCampaigne[$company_id]['permitio'])
                            {
                                if (($store1[0]->result==1)  and ($store1[0]->publicity_id==0)){
                                    $permitio='Si';
                                }else{
                                    $permitio='No';
                                }
                            }else{
                                if ($index1==$valoresCampaigne[$company_id]['existeVent'])
                                {
                                    if (($store1[0]->result==1)  and ($store1[0]->publicity_id==$publicity_id)){
                                        $existeVent="Si";
                                    }else{
                                        $existeVent="No";
                                    }
                                }else{
                                    if ($index1==$valoresCampaigne[$company_id]['ventanaW'])
                                    {
                                        if ($trabajada==1)
                                        {
                                            if (($store1[0]->result==1)  and ($store1[0]->publicity_id==$publicity_id)){
                                                $ventW = "Si";
                                            }else{
                                                $ventW = "No";
                                            }
                                        }else{
                                            if (($store1[0]->result==0)  and ($store1[0]->publicity_id==$publicity_id)){
                                                $ventW = "No";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $resultFiltro[$index] = array('abierto' => $storeAbierto,'permitio' => $permitio,'existe' => $existeVent,'trabajada' => $ventW);
                        //if (($store1[0]->store_id==186667) and ($publicity_id==961)){dd($trabajada,$store1[0],$index1,$this->valoresCampaigne[$company_id]['ventanaW'],$resultFiltro);}
                    }
                    //if ($store1[0]->store_id==186667){dd($resultFiltro);}
                }//dd($resultFiltro);
                $storesxCampaigne=[];
                foreach ($resultFiltro as $index2 =>$store2){
                    if ($trabajada==1){$respW="Si";}else{$respW="No";}
                    if (($store2['abierto']=="Si") and ($store2['permitio']=="Si") and ($store2['existe']=="Si") and ($store2['trabajada']==$respW)){

                        foreach ($grouped[$index2] as $values){
                            if ($values->publicity_id==$publicity_id){
                                $foto = $values->Foto;
                                $sod = $values->sod;
                            }
                        }
                        $storesxCampaigne[] = array('store_id' => $grouped[$index2][0]->store_id,'filtros' => $resultFiltro[$index2],'fullname' =>$grouped[$index2][0]->fullname,'auditor_id' =>$auditor, 'auditor' =>$obAuditor->fullname,'departamento'=>$grouped[$index2][0]->ubigeo,'fecha' =>$grouped[$index2][0]->fecha,'hora' => $grouped[$index2][0]->hora,'result'=>1,'foto' => $foto,'publicity_detail_id' => $grouped[$index2][0]->publicity_details_id,'sod'=>$sod);
                    }
                }
            }else{
                $storesxCampaigne = [];
            }
        }
    }
}
