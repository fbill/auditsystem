<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PollDetailRepo;
use App\Repositories\PollOptionDetailRepo;
use App\Repositories\PollOptionRepo;

class PollDetailsController extends Controller
{
    protected $pollDetailRepo;
    protected $pollOptionDetailRepo;
    protected $pollOptionRepo;

    public function __construct(PollOptionRepo $pollOptionRepo,PollOptionDetailRepo $pollOptionDetailRepo,PollDetailRepo $pollDetailRepo)
    {
        // set the model
        $this->pollDetailRepo = $pollDetailRepo;
        $this->pollOptionDetailRepo = $pollOptionDetailRepo;
        $this->pollOptionRepo = $pollOptionRepo;
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

    public function getRegsForPollId($poll_id,$type,$ubigeo="0")
    {
        $valores = $this->pollDetailRepo->getPollDetailsForPollId($poll_id,$ubigeo);
        $myArray = collect($valores);
        if (($type==1) or ($type==3))
        {
            $filtered = $myArray->where('sino', 1);
            $sinoSi = $filtered->where('result',1);
            if (count($sinoSi)>0)
            {
                foreach ($sinoSi as $item) {
                    $storesSi[]=$item->store_id;
                }
            }else{
                $storesSi[]="";
            }

            $sinoNo = $filtered->where('result',0);
            if (count($sinoNo)>0)
            {
                foreach ($sinoNo as $item) {
                    $storesNo[]=$item->store_id;
                }
            }else{
                $storesNo[]="";
            }

            $results1 = array('type'=>'sino','poll_id'=>$poll_id,'si'=>$sinoSi->count(),'no'=>$sinoNo->count(),'storesSi'=>$storesSi,'storesNo'=>$storesNo);
            if ($type==1){
                return $results1;
            }

        }
        if (($type==2) or ($type==3))
        {
            $options = $this->pollOptionRepo->getOptionsForPollId($poll_id);
            foreach ($options as $option) {
                if ($option->options_abreviado<>'')
                {
                    $nomb_opciones[] = $option->options_abreviado;
                }else{
                    $nomb_opciones[] = $option->options;
                }

                $id_opciones[]  =  $option->id;
                $valores_opciones = $this->pollOptionDetailRepo->getResultForOption($option->id);
                $storesOption[$option->id] = $valores_opciones;
                $myArray = collect($valores_opciones);
                $count_opciones[] = $myArray->count();
            }
            $results2 = array('type'=>'option','poll_id'=>$poll_id,'opciones'=>$nomb_opciones,'count'=>$count_opciones,'options_id'=>$id_opciones,'storesOption'=>$storesOption);
            if ($type==3)
            {
                $results3 = array('type'=>'sino/option','poll_id'=>$poll_id,'si'=>$results1['si'],'no'=>$results1['no'],'storesSi'=>$storesSi,'storesNo'=>$storesNo,'opciones'=>$nomb_opciones,'count'=>$count_opciones,'options_id'=>$id_opciones,'storesOption'=>$storesOption);
                return $results3;
            }
            return $results2;
        }

    }

}
