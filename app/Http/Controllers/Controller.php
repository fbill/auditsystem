<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMenus($audits)
    {
        $menus[] = array('name'=>'Panel de Control','url'=>'/panel','icon'=>'icon-speedometer');
        $menus[] = array('title'=>true,'name'=>'Auditorias');
        foreach ($audits as $audit) {
            $menus[] = array('id'=>$audit->id,'name'=>$audit->audit,'url'=>'/panel','icon'=>'icon-speedometer');
        }
        return $menus;
    }

    public function getAllPollsWeb($companyRepo,$pollRepo,$customer_id, $estudio)
    {
        $companies = $companyRepo->getCompaniesForClient($customer_id,"1",$estudio,"T");

        $group_poll_id='';$c=0;
        if (count($companies)>0)
        {
            foreach ($companies as $company_data)
            {
                $c=$c+1;
                $objPolls = $pollRepo->getQuestionForWeb($company_data->id);
                foreach ($objPolls as $objPoll) {
                    $pollWebs[] = array('company_id'=>$company_data->id,'identificador'=>$objPoll->identificador,'poll_id'=>$objPoll->id);
                }
            }
        }else{
            $pollWebs = [];
        }

        return $pollWebs;
    }

    public function getResponsePolls($pollDetailRepo,$pollOptionDetailRepo,$store_id,$company_id,$publicity_id,$poll_id,$type,$product_id="0")
    {
        if ($type == 'YesNo')
        {
            if ($publicity_id==0){
                if ($product_id =="0")
                {
                    $storeOpen = $pollDetailRepo->getRegForStoreCompanyPoll($store_id,$company_id,$poll_id);
                }else{
                    $storeOpen = $pollDetailRepo->getRegForStoreCompanyPoll($store_id,$company_id,$poll_id,$product_id);
                }

            }else{
                $storeOpen = $pollDetailRepo->getResultForStore($company_id,$store_id,$poll_id,$publicity_id);
            }

            $cantReg = count($storeOpen);//dd($storeOpen[0]);
            /*if ($publicity_id==403){
                dd($company_id);
            }*/
            if ($cantReg>0)
            {
                if ($storeOpen[0]->result==1){
                    $texto = "Sí (".$storeOpen[0]->created_at.")";
                }else{
                    $texto = "No (".$storeOpen[0]->created_at.")";
                }
                $responses = array('texto' => $texto,'objeto' => $storeOpen);
            }else{
                $responses = array('texto' => "No hay ingreso",'objeto' => []);
            }
        }
        if ($type == 'Option')
        {
            $storeComoEsta = $pollDetailRepo->getResultForStore($company_id,$store_id,$poll_id,$publicity_id);//dd($storeComoEsta);
            $cantReg = count($storeComoEsta);
            if ($cantReg>0)
            {
                $responseOption = $pollOptionDetailRepo->getResponseOptionPublicity($store_id,$poll_id,$publicity_id,$company_id);//dd($responseOption);
                $cantReg = count($responseOption);
                if ($cantReg>0)
                {
                    $texto = "Opciones seleccionadas"."<br>";
                    $texto .= "<ul>";
                    foreach ($responseOption as $option)
                    {
                        $texto .= "<li>".$option->options."(".$option->id.") - ".$option->created_at."</li>";
                        $id = $option->id;
                        $poll_option_details_id = $option->poll_option_details_id;
                    }
                    $texto .= "</ul>";
                }else{
                    $texto = "No Hay Opciones ingresadas ";$id=0;$poll_option_details_id=0;
                }
                $responses = array('texto' => $texto,'objeto' => $storeComoEsta,'options' => $responseOption, 'id' =>$id ,'poll_option_details_id' => $poll_option_details_id);
            }else{
                $responses = array('texto' => 'No hay registros','objeto' => [],'options' => [], 'id' => 0 );
            }
        }
        return $responses;
    }
}
