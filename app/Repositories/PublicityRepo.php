<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Publicity;
use Illuminate\Support\Facades\DB;

class PublicityRepo extends Repository
{

    public function getModel()
    {
        return new Publicity;
    }

    public function getPublicitiesForCategory($category_product_id,$campaigne_id)
    {
        $valores = Publicity::where('category_product_id', $category_product_id)->where('company_id',$campaigne_id)->get();
        return $valores;
    }

    public function getPublicityAlicorp($ubigeo,$auditor_id,$publicity_id,$company_id)
    {

        $sql1="call sp_reporte_company_all('".$ubigeo."','".$auditor_id."','".$publicity_id."','".$company_id."')";
        $consulta1 = \DB::select($sql1);//dd($sql1);
        return $consulta1;
    }

}