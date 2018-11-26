<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Company;

class CompanyRepo extends Repository
{

    public function getModel()
    {
        return new Company;
    }


    public function listCompanies()
    {
        $companies = Company::paginate();
        return $companies;
    }

    public function getCompaniesForClient($client_id,$visible="1",$estudio="",$active="1")
    {
        if ($estudio<>""){
            if ($visible=="T"){
                $consulta = Company::where('customer_id', $client_id)->where('study_id',$estudio)->get();
            }else{
                if ($active=="T"){
                    $consulta = Company::where('customer_id', $client_id)->where('visible',$visible)->where('study_id',$estudio)->orderBy('id','ASC')->get();
                }else{
                    $consulta = Company::where('customer_id', $client_id)->where('active',$active)->where('visible',$visible)->where('study_id',$estudio)->orderBy('id','ASC')->get();
                }
            }
        }else{
            if ($visible=="T"){
                $consulta = Company::where('customer_id', $client_id)->get();
            }else{
                if ($active=="T"){
                    $consulta = Company::where('customer_id', $client_id)->where('visible',$visible)->get();
                }else{
                    $consulta = Company::where('customer_id', $client_id)->where('active',$active)->where('visible',$visible)->get();
                }
            }
        }


        return $consulta;
    }
}