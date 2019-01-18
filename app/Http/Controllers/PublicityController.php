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

        $objPolls = $this->pollRepo->getQuestionForWeb($company_id);//dd($objPolls);
        foreach ($objPolls as $objPoll) {
            if (($objPoll['identificador']=='abierto') and ($objPoll['company_id']==$company_id))
            {
                $valoresCampaigne[$company_id]['abierto'] = $objPoll['id'];
            }
            if (($objPoll['identificador']=='permitio') and ($objPoll['company_id']==$company_id))
            {
                $valoresCampaigne[$company_id]['permitio'] = $objPoll['id'];
            }
            if (($objPoll['identificador']=='existeVent') and ($objPoll['company_id']==$company_id))
            {
                $valoresCampaigne[$company_id]['existeVent'] = $objPoll['id'];
            }
            if (($objPoll['identificador']=='ventanaW') and ($objPoll['company_id']==$company_id))
            {
                $valoresCampaigne[$company_id]['ventanaW'] = $objPoll['id'];
            }
        }
        $storesxCampaigne1 = $this->publicityRepo->getPublicityAlicorp($city,$auditor,$publicity_id,$company_id);

        if ($tipo=="Sod"){
            if (count($storesxCampaigne1)>0)
            {
                $collectStores = Collection::make($storesxCampaigne1);//dd($collectStores);
                $groupedAbierto = $collectStores->where('poll_id',$valoresCampaigne[$company_id]['abierto'])->where('result',1);
                $grouped = $groupedAbierto->groupBy('store_id');
                $groupedPermitio = $collectStores->where('poll_id',$valoresCampaigne[$company_id]['permitio'])->where('result',1);
                $grouped1 = $groupedPermitio->groupBy('store_id');
                $groupedExiste = $collectStores->where('poll_id',$valoresCampaigne[$company_id]['existeVent'])->where('result',1);
                $grouped2 = $groupedExiste->groupBy('store_id');
                $groupedTrabajada = $collectStores->where('poll_id',$valoresCampaigne[$company_id]['ventanaW'])->where('result',$trabajada);
                $grouped3 = $groupedTrabajada->groupBy('store_id');

                foreach ($grouped as $index =>$store)
                {
                    foreach ($grouped1 as $index1=>$item) {
                        if ($index==$index1)
                        {
                            $filterCol[$index] = $item;break;
                        }
                    }

                }
                foreach ($filterCol as $index => $store) {
                    foreach ($grouped2 as $index1=> $item) {
                        if ($index==$index1)
                        {
                            $filterCol1[$index] = $item;break;
                        }
                    }
                }

                foreach ($filterCol1 as $index=> $store) {
                    foreach ($grouped3 as $index1=> $item) {
                        if ($index==$index1)
                        {
                            $storesxCampaigne[$index] = $item;break;
                        }
                    }
                }

                foreach ($storesxCampaigne as $item) {
                    $resultEnd[] = $item[0];
                }
                $resultEnd1 = collect($resultEnd);
                $resultSodNoMedidos = $resultEnd1->where('sod','<>',1);
                $baseNoMedidos = $resultSodNoMedidos->groupBy('store_id');
            }else{
                $storesxCampaigne = [];
                $baseNoMedidos = [];
            }
            $responsesSod = array('Base'=>$storesxCampaigne,'TotalBase'=>count($storesxCampaigne),'BaseNoMedidos'=>$baseNoMedidos,'TotalNoMedidos'=>count($baseNoMedidos));
            return $responsesSod;
        }
        //return $storesxCampaigne;
    }
}
