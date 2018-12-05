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
            $sinoNo = $filtered->where('result',0);
            $results1 = array('type'=>'sino','poll_id'=>$poll_id,'si'=>$sinoSi->count(),'no'=>$sinoNo->count());
            if ($type==1){
                return $results1;
            }

        }
        if (($type==2) or ($type==3))
        {
            $options = $this->pollOptionRepo->getOptionsForPollId($poll_id);
            foreach ($options as $option) {
                $nomb_opciones[] = $option->options;
                $valores_opciones = $this->pollOptionDetailRepo->getResultForOption($option->id);
                $myArray = collect($valores_opciones);
                $count_opciones[] = $myArray->count();
            }
            $results2 = array('type'=>'option','poll_id'=>$poll_id,'opciones'=>$nomb_opciones,'count'=>$count_opciones);
            if ($type==3)
            {
                $results3 = array('type'=>'sino/option','poll_id'=>$poll_id,'si'=>$results1['si'],'no'=>$results1['no'],'opciones'=>$nomb_opciones,'count'=>$count_opciones);
                return $results3;
            }
            return $results2;
        }

    }

}
